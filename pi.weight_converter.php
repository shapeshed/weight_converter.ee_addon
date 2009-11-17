<?php
/** 
 * ExpressionEngine
 *
 * LICENSE
 *
 * ExpressionEngine by EllisLab is copyrighted software
 * The licence agreement is available here http://expressionengine.com/docs/license.html
 * 
 * File Oracle
 * 
 * @category   Plugins
 * @package    Weight Converter
 * @version    0.1.0
 * @since      0.1.0
 * @author     George Ornbo <george@shapeshed.com>
 * @see        {@link http://github.com/shapeshed/unit_converter.git/} 
 * @license    {@link http://opensource.org/licenses/bsd-license.php} 
 */

/**
* Plugin information used by ExpressionEngine
* @global array $plugin_info
*/
$plugin_info = array(
						'pi_name'			=> 'Weight Converter',
						'pi_version'		=> '0.1.0',
						'pi_author'			=> 'George Ornbo',
						'pi_author_url'		=> 'http://shapeshed.com/',
						'pi_description'	=> 'Converts a number from one weight to another',
						'pi_usage'			=> Weight_converter::usage()
					);

class Weight_converter{
	
	/**
	* The units that can be converted using this class
	* @see __construct
	* @var array
	*/	
	private $units = array('lb', 'g', 'kg', 'oz', 'st', 'short_ton', 'long_ton');

	/**
	* Data sent back to calling function
	* @var string
	*/	
	public $return_data;
	
	/**
	* Variable to hold the converted unit
	* @var string
	*/	
	private $converted_unit;
	
  /**
  * Variable to hold the converted int after conversion
  * @var int
  */
  private $converted_num;

	/**
	* ExpressionEngine needs this as it is PHP4 based so doesn't get __construct()
	* @access public
	*/
	public function Unit_converter()
	{
		$this->__construct();
	}

	/**
	* Constructor class. Assesses the unit and does the conversion
	* @access public
	* @return array
	*/
	public function __construct() 
	{		
    global $TMPL;	

    $TMPL->tagdata;

    if (!is_numeric($TMPL->tagdata))
    {
      return $this->return_data = 'Please check your input - it is not a number';
    }

    $this->from = $TMPL->fetch_param('from');
    $this->to = $TMPL->fetch_param('to');
    
    if (!in_array($this->from, $this->units)) {
      return $this->return_data = 'The from unit is not supported. Please check your syntax';
    }
    
    if (!in_array($this->to, $this->units)) {
      return $this->return_data = 'The to unit is not supported. Please check your syntax';
    }

    $this->decimals = ( ! $TMPL->fetch_param('decimals')) ? 2 : $TMPL->fetch_param('decimals');
    $this->dec_point = ( ! $TMPL->fetch_param('dec_point')) ? '.' : $TMPL->fetch_param('dec_point');
    $this->thousands_sep = ( ! $TMPL->fetch_param('thousands_sep')) ? ' ' : $TMPL->fetch_param('thousands_sep');

    switch ($this->from) 
    {
    case 'lb':
      $converted_num = $this->convert_lb($this->to, $TMPL->tagdata);
      break;
    case 'g':
      $converted_num = $this->convert_g($this->to, $TMPL->tagdata);
      break;
    case 'kg':
      $converted_num = $this->convert_kg($this->to, $TMPL->tagdata);
      break;
    case 'oz':
      $converted_num = $this->convert_oz($this->to, $TMPL->tagdata);
      break;
    case 'st':
      $converted_num = $this->convert_st($this->to, $TMPL->tagdata);
      break;
    case 'short_ton':
      $converted_num = $this->convert_short_ton($this->to, $TMPL->tagdata);
      break;
    case 'long_ton':
      $converted_num = $this->convert_short_ton($this->to, $TMPL->tagdata);
      break;
    default:
      return $this->return_data = 'Unable to convert, please check your the units in your template';
    }

    $this->return_data = number_format($converted_num, $this->decimals, $this->dec_point, $this->thousands_sep);

	}
	
  /**
  * Converter for lbs
  * @access private
  * @return string
  */		
  private function convert_lb($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 1;     
    case 'g':
      $this->converted_unit = $tagdata * 453.59237;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 0.45359237;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 16;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 0.07142857;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 0.0005;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.00044642857142857;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for grams
  * @access private
  * @return string
  */		
  private function convert_g($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 0.0022046226218488;     
    case 'g':
      $this->converted_unit = $tagdata * 1;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 0.001;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 0.03527396194958;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 0.000157473044;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 0.0000011023113109244;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.00000098420652761106;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for kgs
  * @access private
  * @return string
  */		
  private function convert_kg($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 2.2046226218488;     
    case 'g':
      $this->converted_unit = $tagdata * 1000;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 1;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 35.27396194958;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 0.157473044;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 0.0011023113109244;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.00098420652761106;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for ounces
  * @access private
  * @return string
  */		
  private function convert_oz($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 0.0625;     
    case 'g':
      $this->converted_unit = $tagdata * 28.349523125;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 0.028349523125;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 1;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 0.00446428571;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 0.00003125;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.000027901785714286;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for stones
  * @access private
  * @return string
  */		
  private function convert_st($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 0.0625;     
    case 'g':
      $this->converted_unit = $tagdata * 28.349523125;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 0.028349523125;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 224;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 1;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 0.00003125;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.000027901785714286;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for short tons
  * @access private
  * @return string
  */		
  private function convert_short_ton($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 2000;     
    case 'g':
      $this->converted_unit = $tagdata * 907184.74;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 907.18474;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 32000;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 142.857143;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 1;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 0.89285714285714;
    }
    return $this->converted_unit; 	
  }
  
  /**
  * Converter for long tons
  * @access private
  * @return string
  */		
  private function convert_long_ton($to, $tagdata)
  {
    switch ($to) 
    {
    case 'lb':
      $this->converted_unit = $tagdata * 2240;     
    case 'g':
      $this->converted_unit = $tagdata * 1016046.9088;
      break;
    case 'kg':
      $this->converted_unit = $tagdata * 1016.0469088;
      break;
    case 'oz':
      $this->converted_unit = $tagdata * 35840;
      break;
    case 'st':
      $this->converted_unit = $tagdata * 160;
      break;
    case 'short-tons':
      $this->converted_unit = $tagdata * 1.12;
      break;
    case 'long-tons':
      $this->converted_unit = tagdata * 1.12;
    }
    return $this->converted_unit; 	
  }

  /**
  * Plugin usage documentation
  *
  * @return	string Plugin usage instructions
  */
  public function usage()
  {
    return "Documentation is available here http://shapeshed.github.com/expressionengine/plugins/weight_converter/";
  }
	
}

?>