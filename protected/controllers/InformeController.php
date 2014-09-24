<?php

class InformeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('InformePpt','InformePdf'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionInformePpt( $params = array())
	{
		if(isset($params['multi']) && $params['multi'] == true && isset($params['ids']) && is_array($params['ids']) && !empty($params['ids'])){
			$ids = $params['ids'];
		}
		elseif(isset($params['id']) && !empty($params['id'])){
			$id = Visita::model()->findByPk($params['id']);
		}
		else{
			$objPHPPowerPoint = new PhpOffice\PhpPowerpoint\PhpPowerpoint();

			error_reporting(E_ALL);
			define('CLI', (PHP_SAPI == 'cli') ? true : false);
			define('EOL', CLI ? PHP_EOL : '<br />');
			define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
			define('IS_INDEX', SCRIPT_FILENAME == 'index');

			// Set writers
			$writers = array('PowerPoint2007' => 'pptx', 'ODPresentation' => 'odp');

			// Return to the caller script when runs by CLI
			if (CLI) {
				return;
			}

			// Set titles and names
			$pageHeading = str_replace('_', ' ', SCRIPT_FILENAME);
			$pageTitle = IS_INDEX ? 'Welcome to ' : "{$pageHeading} - ";
			$pageTitle .= 'PHPPowerPoint';
			$pageHeading = IS_INDEX ? '' : "<h1>{$pageHeading}</h1>";

			// Populate samples
			$files = '';
			if ($handle = opendir('.')) {
				while (false !== ($file = readdir($handle))) {
					if (preg_match('/^Sample_\d+_/', $file)) {
						$name = str_replace('_', ' ', preg_replace('/(Sample_|\.php)/', '', $file));
						$files .= "<li><a href='{$file}'>{$name}</a></li>";
					}
				}
				closedir($handle);
			}



			// Set properties
			$objPHPPowerPoint->getProperties()->setCreator('PHPOffice')
			                                  ->setLastModifiedBy('PHPPowerPoint Team')
			                                  ->setTitle('Sample 01 Title')
			                                  ->setSubject('Sample 01 Subject')
			                                  ->setDescription('Sample 01 Description')
			                                  ->setKeywords('office 2007 openxml libreoffice odt php')
			                                  ->setCategory('Sample Category');

			// Create slide
			$currentSlide = $objPHPPowerPoint->getActiveSlide();

			// Create a shape (drawing)
			$shape = $currentSlide->createDrawingShape();
			$shape->setName('PHPPowerPoint logo')
			      ->setDescription('PHPPowerPoint logo')
			      ->setPath(Yii::getPathOfAlias('webroot').'/resources/phppowerpoint_logo.gif')
			      ->setHeight(36)
			      ->setOffsetX(10)
			      ->setOffsetY(10);
			$shape->getShadow()->setVisible(true)
			                   ->setDirection(45)
			                   ->setDistance(10);

			// Create a shape (text)
			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(170)
			      ->setOffsetY(180);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
			$textRun = $shape->createTextRun('Thank you for using PHPPowerPoint!');
			$textRun->getFont()->setBold(true)
			                   ->setSize(60)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( 'FFE06B20' ) );

			// Save file
			echo $this->write($objPHPPowerPoint, 'test.php', $writers);
		}
		
	}

	public function actionInformePdf( $params = array())
	{
		if(isset($params['multi']) && $params['multi'] == true && isset($params['ids']) && is_array($params['ids']) && !empty($params['ids'])){
			$ids = $params['ids'];
		}
		elseif(isset($params['id']) && !empty($params['id'])){
			$id = Visita::model()->findByPk($params['id']);
		}
		else return false;
	}

		/**
	 * Write documents
	 *
	 * @param \PhpOffice\PhpWord\PhpWord $phpWord
	 * @param string $filename
	 * @param array $writers
	 */
	function write($phpPowerPoint, $filename, $writers)
	{
		$result = '';
		
		// Write documents
		foreach ($writers as $writer => $extension) {
			$result .= date('H:i:s') . " Write to {$writer} format";
			if (!is_null($extension)) {
				$xmlWriter = PhpOffice\PhpPowerpoint\IOFactory::createWriter($phpPowerPoint, $writer);
				$xmlWriter->save(__DIR__ . "/{$filename}.{$extension}");
				//rename(__DIR__ . "/{$filename}.{$extension}", __DIR__ . "/results/{$filename}.{$extension}");
			} else {
				$result .= ' ... NOT DONE!';
			}
			$result .= EOL;
		}

		$result .= $this->getEndingNotes($writers);

		return $result;
	}

	/**
	 * Get ending notes
	 *
	 * @param array $writers
	 */
	function getEndingNotes($writers)
	{
		$result = '';

		// Do not show execution time for index
		if (!IS_INDEX) {
			$result .= date('H:i:s') . " Done writing file(s)" . EOL;
			$result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
		}

		// Return
		if (CLI) {
			$result .= 'The results are stored in the "results" subdirectory.' . EOL;
		} else {
			if (!IS_INDEX) {
				$types = array_values($writers);
				$result .= '<p>&nbsp;</p>';
				$result .= '<p>Results: ';
				foreach ($types as $type) {
					if (!is_null($type)) {
						$resultFile = 'results/' . SCRIPT_FILENAME . '.' . $type;
						if (file_exists($resultFile)) {
							$result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
						}
					}
				}
				$result .= '</p>';
			}
		}

		return $result;
	}

	/**
	 * Creates a templated slide
	 *
	 * @param PHPPowerPoint $objPHPPowerPoint
	 * @return PHPPowerPoint_Slide
	 */
	function createTemplatedSlide(PhpOffice\PhpPowerpoint\PhpPowerpoint $objPHPPowerPoint)
	{
		// Create slide
		$slide = $objPHPPowerPoint->createSlide();
		
		// Add logo
		$shape = $slide->createDrawingShape();
		$shape->setName('PHPPowerPoint logo')
			->setDescription('PHPPowerPoint logo')
			->setPath('./resources/phppowerpoint_logo.gif')
			->setHeight(36)
			->setOffsetX(10)
			->setOffsetY(10);
		$shape->getShadow()->setVisible(true)
			->setDirection(45)
			->setDistance(10);

		// Return slide
		return $slide;
	}
}