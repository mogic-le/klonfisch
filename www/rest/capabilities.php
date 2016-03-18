<?php
require_once __DIR__ . '/../www-header.php';
header('Content-type: application/json');
?>
{
  "capabilities": {
    "atlassian-remote-event-producer": "<?= $klonfischUrl ?>/rest/remote-event-producer/1/capabilities",
    "atlassian-remote-event-consumer": "<?= $klonfischUrl ?>/rest/remote-event-consumer/1/capabilities",
    "atlassian-remote-event-status": "<?= $klonfischUrl ?>/rest/remote-event/1/status",
    "navigation": "<?= $klonfischUrl ?>/rest/capabilities/navigation",
    "dev-status-detail-repository": "<?= $klonfischUrl ?>/rest/jira-dev/latest/detail/repository",
    "atlassian-remote-event-diagnostics-v1": "<?= $klonfischUrl ?>/rest/remote-event/1/status",
    "bitbucket-remote-event-support": "<?= $klonfischUrl ?>/rest/bitbucket-remote/latest/remote-event-support",
    "dev-status-summary": "<?= $klonfischUrl ?>/rest/remote-link-aggregation/latest/aggregation",
    "dev-status-detail-pullrequest": "<?= $klonfischUrl ?>/rest/jira-dev/latest/detail/pullrequest",
    "remote-link-aggregation": "<?= $klonfischUrl ?>/rest/remote-link-aggregation/1/capabilities",
    "smart-commit-producer": "<?= $klonfischUrl ?>/rest/jira-dev/latest/smart-commit"
  },
  "buildDate": "2016-03-02T06:36:47Z",
  "application": "stash",
  "links": {
    "self": "<?= $klonfischUrl ?>/rest/capabilities"
  }
}
