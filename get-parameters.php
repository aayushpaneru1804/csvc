<?php
  # Retrieve settings from Secrets Manager
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  error_log('Retrieving settings from Secrets Manager');

if (!file_exists('aws.phar')) {
  throw new Exception('Missing aws.phar library in application root');
}
require 'aws.phar';

$az = @file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
if ($az !== false) {
  $region = substr($az, 0, -1);
} else {
  $region = getenv('AWS_REGION') ?: getenv('AWS_DEFAULT_REGION') ?: 'us-east-1';
}

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

  if (!is_array($secret_data)) {
    throw new Exception('Secrets JSON is invalid or empty');
  }

  $ep = $secret_data['host'] ?? '';
  $un = $secret_data['username'] ?? '';
  $pw = $secret_data['password'] ?? '';
  $db = $secret_data['database'] ?? '';
}
catch (Exception $e) {
  error_log('Secret retrieval failed: ' . $e->getMessage());
  $ep = '';
  $db = '';
  $un = '';
  $pw = '';
}

?>