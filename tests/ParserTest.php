<?php 

require_once './Product.php';
class ParserTest extends \PHPUnit\Framework\TestCase
{
  public function testParseCsv()
  {
    // $csvData = "Make,Model,Colour,Capacity,Network,Grade,Condition,Price\n"
    // . "Samsung,Galaxy S10,Black,128GB,EE,A,New,500\n"
    // . "Apple,iPhone 11,Green,64GB,Three,B,CPO,450\n"
    // . "Samsung,Galaxy S10,Black,128GB,Vodafone,A,New,480\n"
    // . "Apple,iPhone 12,Red,128GB,O2,A,New,800\n"
    // . "Samsung,Galaxy S10,Black,256GB,EE,B,New,550\n"
    // . "Samsung,Galaxy S10,White,128GB,Vodafone,A,New,480\n";

     // Parse CSV data
     $parser = new product("Samsung","Galaxy S10","Black","128GB","EE","A","New","500");
     $products = $parser->parse_csv('./examples/TestData.csv');

    //  $this->assertEquals(count($products), 6);
    var_dump($products[0]);
     $this->assertEquals($products[0]->make, "AASTRA");
     $this->assertEquals($products[0]->model, "Galaxy S10");
     $this->assertEquals($products[0]->colour, "Black");
     $this->assertEquals($products[0]->capacity, "128GB");
     $this->assertEquals($products[0]->network, "EE");
     $this->assertEquals($products[0]->grade, "A");
     $this->assertEquals($products[0]->condition, "New");
     $this->assertEquals($products[0]->price, "500");
  }

  private function getCsvRows($filename) {
    $rows = array();
    $file = fopen($filename, 'r');
    while (($data = fgetcsv($file)) !== false) {
      $rows[] = $data;
    }
    fclose($file);
    return $rows;
  }
}