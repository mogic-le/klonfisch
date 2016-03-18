<?php
require_once __DIR__ . '/../../../www-header.php';
header('Content-Type: application/xml');
?>
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<manifest>
  <id><?php echo $klonfischUuid; ?></id>
  <name>Klonfisch</name>
  <typeId>stash</typeId>
  <version>4.4.1</version>
  <buildNumber>4004001</buildNumber>
  <applinksVersion>5.0.5</applinksVersion>
  <inboundAuthenticationTypes>com.atlassian.applinks.api.auth.types.BasicAuthenticationProvider</inboundAuthenticationTypes>
  <inboundAuthenticationTypes>com.atlassian.applinks.api.auth.types.TwoLeggedOAuthWithImpersonationAuthenticationProvider</inboundAuthenticationTypes>
  <outboundAuthenticationTypes>com.atlassian.applinks.api.auth.types.BasicAuthenticationProvider</outboundAuthenticationTypes>
  <outboundAuthenticationTypes>com.atlassian.applinks.api.auth.types.TwoLeggedOAuthWithImpersonationAuthenticationProvider</outboundAuthenticationTypes>
  <publicSignup>false</publicSignup>
  <url><?php echo $klonfischUrl; ?></url>
  <iconUri><?php echo $klonfischUrl; ?>/favicon.png</iconUri>
</manifest>
