<?php
  # Retrieve settings from Secrets Manager using AWS CLI to avoid deprecated SDK issues.
  ini_set('display_errors', 1);
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$region = getenv('AWS_REGION') ?: getenv('AWS_DEFAULT_REGION');
if (empty($region)) {
  $az = @file_get_contents('http://169.254.169.254/latest/meta-data/placement/availability-zone');
  if ($az !== false) {
    $region = substr($az, 0, -1);
  }
}
if (empty($region)) {
  $region = 'us-east-1';
}

$aws_bin = trim(shell_exec('command -v aws 2>/dev/null'));
if ($aws_bin === '') {
  $aws_bin = trim(shell_exec('which aws 2>/dev/null'));
}

$secret_data = null;
if ($aws_bin !== '') {
  $cmd = sprintf(
    '%s secretsmanager get-secret-value --secret-id countries/db/credentials --region %s --query SecretString --output text 2>&1',
    escapeshellarg($aws_bin),
    escapeshellarg($region)
  );
  $secret_json = trim(shell_exec($cmd));
} else {
  $secret_json = '';
}

if ($secret_json === '' || stripos($secret_json, 'error') !== false) {
  error_log('Secret retrieval failed: ' . $secret_json);
} else {
  $secret_data = json_decode($secret_json, true);
}

if (!is_array($secret_data)) {
  $ep = getenv('DB_HOST') ?: '';
  $un = getenv('DB_USER') ?: '';
  $pw = getenv('DB_PASS') ?: '';
  $db = getenv('DB_NAME') ?: '';
} else {
  $ep = $secret_data['host'] ?? '';
  $un = $secret_data['username'] ?? '';
  $pw = $secret_data['password'] ?? '';
  $db = $secret_data['database'] ?? '';
}

?>