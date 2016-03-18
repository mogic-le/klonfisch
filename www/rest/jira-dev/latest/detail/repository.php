<?php
/**
 * Lists commits for a given keyword.
 * Used by the Jira issue and project "Source" tab.
 *
 * PHP version 5
 *
 * @category Tools
 * @package  Klonfisch
 * @author   Christian Weiske <weiske@mogic.com>
 * @license  AGPLv3 or later
 * @link     https://gitorious.nr/klonfisch
 */
require_once __DIR__ . '/../../../../www-header.php';

if (!isset($_GET['globalId'])) {
    header('HTTP/1.0 400 Bad Request');
    echo "globalId GET parameter missing\n";
    exit(1);
}

$keyword = $_GET['globalId'];
if ($keyword == '') {
    header('HTTP/1.0 400 Bad Request');
    echo "globalId is empty\n";
    exit(1);
}

$orderByChangesets = ' ORDER BY c_date DESC';
$limitChangesets   = '';

$bListRevisions = false;
$nRevisionsFrom = 0;
$nRevisionsTo   = 10;

$db = new PDO(
    $dbDsn, $dbUser, $dbPass,
    array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_PERSISTENT => false
    )
);
$stmt = $db->prepare(
    'SELECT commits.* FROM commits'
    . ' JOIN keywords_commits USING (c_id)'
    . ' JOIN keywords USING (k_id)'
    . ' WHERE k_keyword = :keyword'
    . $orderByChangesets
    . $limitChangesets
);

checkDbResult($stmt, $stmt->execute(array(':keyword' => $keyword)));
header('Content-Type: application/json');

$output = new stdClass();
$output->repositories = array();

//FIXME: group by gitlab project
$repo = array(
    'avatar'  => $klonfischUrl . '/project.png',//FIXME
    'avatarDescription' => 'testproject',//FIXME
    'commits' => array(),
    'name'    => 'testproject',//FIXME
    'url'     => $gitlabUrl,//FIXME
);
while ($arRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $repo['commits'][] = array(
        'author' => array(
            'avatar' => $klonfischUrl . '/favicon.png',//FIXME
            'name'   => preg_replace('# <.*>$#', '', $arRow['c_author'])
        ),
        'authorTimestamp' => date('c', strtotime($arRow['c_date'])),
        'displayId'       => substr($arRow['c_hash'], 0, 7),
        'fileCount'       => 0,//FIXME
        'files'           => array(
            /*
            array(
                'changeType' => 'MODIFIED',
                'path'       => 'file.ext',
                'url' => 'path/to/commit/url#file.ext'
            )
            */
        ),
        'id'      => $arRow['c_hash'],
        'merge'   => false,//FIXME
        'message' => $arRow['c_message'],
        'url'     => $arRow['c_url'],
    );
}
$output->repositories[] = $repo;

echo json_encode($output);
?>
