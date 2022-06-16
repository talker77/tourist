<?php


$dirname = dirname(__FILE__);
$paths = explode("public", $dirname);
$repo_dir = $paths[0];

// Full path to git binary is required if git is not in your PHP user's path. Otherwise just use 'git'.
$git_bin_path = 'git';
$php_bin_path = "/usr/bin/php";



$update = false;

// Parse data from Bitbucket hook payload
$payload = json_decode($_POST['payload']);
$tag_name = date('ydmhis');

/*
su ec2-user -c "$git_bin_path tag tag_b_$tag_name"
su ec2-user  -c "git push --tags"
su ec2-user  -c "git fetch origin"
su ec2-user  -c "git reset --hard origin/master"
*/

$commandDeploy = array();
$commandDeploy[] = 'cd ' . $repo_dir . ' && '."$git_bin_path tag tag_b_$tag_name 2>&1";
$commandDeploy[] = 'cd ' . $repo_dir . ' && '."$git_bin_path fetch origin 2>&1";
$commandDeploy[] = 'cd ' . $repo_dir . ' && '."$git_bin_path reset --hard origin/master 2>&1";
$commandDeploy[] = 'cd ' . $repo_dir . ' && '."$php_bin_path bin/console cache:clear --env=prod 2>&1";
$commandDeploy[] = 'cd ' . $repo_dir . ' && '."$php_bin_path bin/console assets:install --env=prod 2>&1";



function slackPost($message, $channel)
{
    $ch = curl_init("https://hooks.slack.com/services/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");
    $data = http_build_query(
        array('payload'=>
            json_encode(array('text'=>$message,'username'=>"Deployer"))
        )
    );
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}


if (empty($payload->commits)){
    // When merging and pushing to bitbucket, the commits array will be empty.
    // In this case there is no way to know what branch was pushed to, so we will do an update.
    $update = true;
} else {
    foreach ($payload->commits as $commit) {
        $branch = $commit->branch;
        if ($branch === 'master' || isset($commit->branches) && in_array('master', $commit->branches)) {
            $update =	true;
            break;
        }
    }
}

echo "<pre>";

if ($update) {
    // Do a git checkout to the web root
    $passoutput =null;
    foreach($commandDeploy as $task)
    {
        echo "$task".chr(10);
        $output = shell_exec($task);
        echo $output.chr(10);
        $passoutput.=$output;
    }

}

echo "</pre>";

$res =slackPost($output, '#mcvip');

