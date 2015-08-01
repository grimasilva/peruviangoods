<?php

class CompraController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'autocomplete', 'admin', 'autocompletel', 'create1'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate2()
	{
		$model=new Compra;
                $detalle = new Detallecompra;
                //$this->performAjaxValidation(array($model, $detalle));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Compra'], $_POST['Detallecompra']))
		{
			$model->attributes=$_POST['Compra'];                       
                        $detalle->attributes=$_POST['Detallecompra'];
                        
                        $valid=$model->validate();
                        $valid=$detalle->validate() && $valid;
                        if($valid){
                            $model->save(false);
                            $detalle->save(false);
                            $this->redirect('index');
                        }
				
		}
		$this->render('create',array(
			'model'=>$model, 'detalle'=>$detalle,
		));
	}
        
        public function actionCreate() {
            Yii::import('ext.multimodelform.MultiModelForm');
            $model = new Compra();
            $member = new Detallecompra();
            $validatedMembers = array();  //ensure an empty array

            if(isset($_POST['Compra']))
            {
                $model->attributes=$_POST['Compra'];

                if( //validate detail before saving the master
                    MultiModelForm::validate($member,$validatedMembers,$deleteItems) &&
                    $model->save()
                   )
                 
                      $masterValues = array ('NumCompra'=>$model->NumCompra);
                     if (MultiModelForm::save($member,$validatedMembers,$deleteMembers,$masterValues)){
                     $this->redirect(array('view','id'=>$model->NumCompra));
                     
                     }
                    }
           

            $this->render('create',array(
                'model'=>$model,
                //submit the member and validatedItems to the widget in the edit form
                'member'=>$member,
                'validatedMembers' => $validatedMembers,
            ));
            }

            /**
             * Updates a particular model.
             * If update is successful, the browser will be redirected to the 'view' page.
             * @param integer $id the ID of the model to be updated
             */
            public function actionUpdate($id)
            {
                    $model=$this->loadModel($id);

                    // Uncomment the following line if AJAX validation is needed
                    // $this->performAjaxValidation($model);

                    if(isset($_POST['Compra']))
                    {
                            $model->attributes=$_POST['Compra'];
                            if($model->save())
                                    $this->redirect(array('view','id'=>$model->NumCompra));
                    }

                    $this->render('update',array(
                            'model'=>$model,
                    ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Compra');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Venta('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Compra']))
			$model->attributes=$_GET['Compra'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionAutoComplete() {
           
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(Descripcion)', strtolower($_GET['term']), true);
//          $criteria->compare('LOWER(CodProducto)', strtolower($_GET['term']), true, 'OR');
            $criteria->order = 'Descripcion';
            $criteria->limit = 30; 
            $data = Producto::model()->findAll($criteria);

            if (!empty($data))
            {
             $arr = array();
             foreach ($data as $item) {
              $arr[] = array(
                'id' => $item->CodProducto,
                'value' => $item->Descripcion,
                'precio' => $item->PreVenta,
                'label' => $item->Descripcion,
//                'unimedida'=>$item->Unimedida,
              );
             }
            }
            else
            {
             $arr = array();
             $arr[] = array(
              'id' => '',
              'value' => 'No se han encontrado resultados para su búsqueda',
              'label' => 'No se han encontrado resultados para su búsqueda',
             );
         }

         echo CJSON::encode($arr);
            
            
            /* $res = array();

            if (isset($_POST['term']))
            {
               $criteria = new CDbCriteria();
                $criteria->addSearchCondition('Descripcion', $_GET['term']);
                $models = Producto::model()->findAll($criteria);
                
                $qtxt = "SELECT Descripcion, CodProducto, PreCompra FROM productos WHERE Descripcion LIKE :descripcion LIMIT 5";
                $command = Yii::app()->db->createCommand($qtxt);
                $command->bindValue(":descripcion", '%'.$_POST['term'].'%', PDO::PARAM_STR);
                $res = $command->queryRow($fetchAssociative = true);

            }
            echo CJSON::encode($res);
            Yii::app()->end();

        */
        }
        
        public function actionAutoCompletel() {
           
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(CodCliente)', strtolower($_GET['term']), true);
//          $criteria->compare('LOWER(CodProducto)', strtolower($_GET['term']), true, 'OR');
            $criteria->order = 'CodCliente';
            $criteria->limit = 30; 
            $data = Cliente::model()->findAll($criteria);

            if (!empty($data))
            {
             $arr = array();
             foreach ($data as $item) {
              $arr[] = array(
                'id' => $item->CodCliente,
                'value' => $item->CodCliente,
                'label' => $item->CodCliente,
                'direccion' => $item->Direccion,
                'nombre'=> $item->Descripcion,
                'telefono'=> $item->Telefono,
                
              );
             }
            }
            else
            {
             $arr = array();
             $arr[] = array(
              'id' => '',
              'value' => 'No se han encontrado resultados para su búsqueda',
              'label' => 'No se han encontrado resultados para su búsqueda',
             );
         }

         echo CJSON::encode($arr);
        }
        public function actionBatchUpdate()
            {
                // retrieve items to be updated in a batch mode
                // assuming each item is of model class 'Item'
            $items = new Venta;
                $items=$this->getItemsToUpdate();
                if(isset($_POST['Compra']))
                {
                    $valid=true;
                    foreach($items as $i=>$item)
                    {
                        if(isset($_POST['Compra'][$i]))
                            $item->attributes=$_POST['Compra'][$i];
                        $valid=$item->validate() && $valid;
                    }
                    
                }
                // displays the view to collect tabular input
                $this->render('create',array('items'=>$items));
            }
        
        

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Venta the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model= Compra::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Venta $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Compra-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
