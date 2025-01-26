<?php
declare(strict_types= 1);

function readJSON() {
  $filepath = "json/accounts.json";
  $content = file_get_contents(filename: $filepath);
  $data = json_decode(json: $content, associative: true);
  return $data;
}

function writeJSON($json) {
  $filepath = "json/accounts.json";
  return file_put_contents($filepath, $json) !== false;
}
