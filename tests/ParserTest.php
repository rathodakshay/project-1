<?php 

require_once './ProductParser.php';
class ParserTest extends \PHPUnit\Framework\TestCase
{
  public function testParseCsv()
  {
  
     $parser = new ProductParser("AASTRA","Galaxy S10","Black","128GB","EE","A","New","500");
     $this->assertEquals($products[0]->make, "AASTRA");
     $this->assertEquals($products[0]->model, "Galaxy S10");
     $this->assertEquals($products[0]->colour, "Black");
     $this->assertEquals($products[0]->capacity, "128GB");
     $this->assertEquals($products[0]->network, "EE");
     $this->assertEquals($products[0]->grade, "A");
     $this->assertEquals($products[0]->condition, "New");
     $this->assertEquals($products[0]->price, "500");
  }
}