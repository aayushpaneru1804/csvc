<?php
  # Retrieve settings from Secrets Manager
  error_log('Retrieving settings');
require 'aws.phar';

$az = file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
$region = substr($az, 0, -1);

try {
  $secrets_client = new Aws\SecretsManager\SecretsManagerClient([
    'version' => 'latest',
    'region'  => $region
  ]);

  # Retrieve secret from Secrets Manager
  $result = $secrets_client->getSecretValue([
    'SecretId' => 'countries/db/credentials'
  ]);

  $secret_json = $result['SecretString'];
  $secret_data = json_decode($secret_json, true);

  $ep = $secret_data['host'];
  $un = $secret_data['username'];
  $pw = $secret_data['password'];
  $db = $secret_data['database'];
  }
  catch (Exception $e) {
  $ep = '';
  $db = '';
  $un = '';
  $pw = '';
}

?>