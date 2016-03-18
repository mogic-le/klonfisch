<?php
/**
 * Lists commits for a given keyword.
 * Used by the Jira issue and project "Source" tab.
 *
 * PHP version 5
 *
 * @category Tools
 * @package  Klonfisch
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  AGPLv3 or later
 * @link     https://gitorious.nr/klonfisch
 */
require_once __DIR__ . '/../../../www-header.php';

if (!isset($_GET['issue'])) {
    header('HTTP/1.0 400 Bad Request');
    echo "issue GET parameter missing\n";
    exit(1);
}

$keyword = $_GET['issue'];
if ($keyword == '') {
    header('HTTP/1.0 400 Bad Request');
    echo "issue is empty\n";
    exit(1);
}

$orderByChangesets = ' ORDER BY c_date DESC';
$limitChangesets   = '';

$bListRevisions = false;
$nRevisionsFrom = 0;
$nRevisionsTo   = 10;
if (isset($_GET['limit'])) {
    $nRevisionsTo = intval($_GET['limit']);
}
//$_GET[useBaseUrlToken]=true???

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

$output = array(
    'isLastPage' => true,
    'limit'  => $nRevisionsTo,
    'size'   => 10,
    'start'  => $nRevisionsFrom,
    'values' => array(),
);
$output->isLast
$xml->startElement('changesets');
while ($arRow = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //necessary for branch links
    $branch = $arRow['c_branch']
        . ' in '
        . $arRow['c_project_name'] . '/'
        . $arRow['c_repository_name'];
    $xml->startElement('changeset');

    $xml->writeElement('csid',    $arRow['c_hash']);
    $xml->writeElement('date',    date('c', strtotime($arRow['c_date'])));
    $xml->writeElement('author',  $arRow['c_author']);
    $xml->writeElement('branch',  $branch);
    $xml->writeElement('comment', $arRow['c_message']);

    $xml->startElement('revisions');
    $xml->writeAttribute('size', 0);
    //FIXME: implement revisions (changes files) - JGA-8
    $xml->endElement();//revisions

    $xml->endElement();//changeset
}
$xml->endElement();//changesets

$xml->endElement();//results
$xml->endDocument();

echo $xml->outputMemory();
?>