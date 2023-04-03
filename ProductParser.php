#!/usr/bin/env php
<?php

class ProductParser {
  public $make;
  public $model;
  public $colour;
  public $capacity;
  public $network;
  public $grade;
  public $condition;
  public $i = 0; 

  public function __construct($make, $model, $colour, $capacity, $network, $grade, $condition) {
    $this->make = $make;
    $this->model = $model;
    $this->colour = $colour;
    $this->capacity = $capacity;
    $this->network = $network;
    $this->grade = $grade;
    $this->condition = $condition;
  }
}
$shortopts  = "";
$shortopts .= "f:";  // Required value
$shortopts .= "r:"; // Optional value

$longopts  = array(
    "required:",     // Required value
    "optional:",    // Optional value
    "option",        // No value
);
$options = getopt($shortopts, $longopts);

function parse_csv($filename,$fileToCreate) {
  $file = fopen($filename, "r");
  if ($file === false) {
    throw new Exception("Failed to open file: $filename");
  }

  $headers = fgetcsv($file);
  $mapping = array(
    'brand_name' => 'brand_name',
    'model_name' => 'model_name',
    'colour_name' => 'colour_name',
    'gb_spec_name' => 'gb_spec_name',
    'network_name' => 'network_name',
    'grade_name' => 'grade_name',
    'condition_name' => 'condition_name',
  );
  $required_fields = array_keys($mapping);
  $product_count = 0;
  $unique_combinations = array();

  while (($data = fgetcsv($file)) !== false && $i < 1000) {
  $i++;
    $product_data = array_combine($headers, $data);
    $missing_fields = array_diff($required_fields, array_keys($product_data));
    if (!empty($missing_fields)) {
      throw new Exception("Missing required fields: " . implode(', ', $missing_fields));
    }
    $product = new Product(
      $product_data[$mapping['brand_name']],
      $product_data[$mapping['model_name']],
      $product_data[$mapping['colour_name']],
      $product_data[$mapping['gb_spec_name']],
      $product_data[$mapping['network_name']],
      $product_data[$mapping['grade_name']],
      $product_data[$mapping['condition_name']]
    );
    $product_count++;
    $combination = "{$product->make}-{$product->model}-{$product->colour}-{$product->capacity}-{$product->network}-{$product->grade}-{$product->condition}";
    if (!isset($unique_combinations[$combination])) {
      $unique_combinations[$combination] = 0;
    }
    $unique_combinations[$combination]++;
    echo "Product $product_count: " . var_export($product, true) . "\n";
  }

  fclose($file);

  $combination_file = $fileToCreate;

  $combination_file_handle = fopen($combination_file, 'w');
  if ($combination_file_handle === false) {
    throw new Exception("Failed to create file: $combination_file");
  }
  fputcsv($combination_file_handle, array('Combination', 'Count'));
  foreach ($unique_combinations as $combination => $count) {
    fputcsv($combination_file_handle, array($combination, $count));
  }
  fclose($combination_file_handle);
}

if (!isset($options['f'])) {
  echo "Please specify a file using -f\n";
  exit(1);
}
if (!isset($options['r'])) {
    echo "Please specify a file name to create -r\n";
    exit(1);
  }
$filename = $options['f'];
$fileToCreate = "./examples/".$options['r'];
try {
  parse_csv($filename, $fileToCreate);
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
  exit(1);
}
