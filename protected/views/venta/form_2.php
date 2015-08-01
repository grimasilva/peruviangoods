<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl?>/css/jquery.css"/>
<script src="<?php echo Yii::app()->request->baseUrl?>/js/jquery-ui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl?>/js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#contador').html(1);
});

</script>
<div id="contador"></div>
<div class="form wide">
 
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'group-form',
            'enableAjaxValidation'=>false,
    )); ?>
 
    <p class="note">Fields with <span class="required">*</span> are required.</p>
 
    <?php
        //show errorsummary at the top for all models
        //build an array of all models to check
        echo $form->errorSummary(array_merge(array($model),$validatedMembers));
    ?>

    <div class="table-responsive">
    <table class="table">
        <th> 
            <div class="required">
                <?php echo $form->labelEx($model,'NumVenta'); ?>
                <?php echo $form->textField($model,'NumVenta'); ?>
                <?php echo $form->error($model,'NunVenta'); ?>
            </div>
        </th>
    
        <th>
            <div class="required">
            <?php echo $form->labelEx($model, 'Fecha');?>
            <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'attribute'=>'Fecha',
                    'model'=>$model,
                    'language'=>'es',
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                        'showButtonPanel'=>TRUE,
                        'changeYear'=>TRUE,
                        'yearRange'=>'-80:-10',
                        'minDate'=>'-80Y',
                        'maxDate'=>'-10Y',
                    )
                ))
             ?>
            <?php echo $form->error($model,'Fecha'); ?>
            </div>
        </th>
    
     <th>
        <div class="required">
        <?php echo $form->labelEx($model, 'Vencimiento');?>
         <?php 
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'attribute'=>'Vencimiento',
                'model'=>$model,
                'language'=>'es',
                'options'=>array(
                    'dateFormat'=>'yy-mm-dd',
                    'showButtonPanel'=>TRUE,
                    'changeYear'=>TRUE,
                )
            ))
         ?>
        <?php echo $form->error($model,'Vencimiento'); ?>
    </div>
    </th>
    </table>
    <table>
    <th>
        <div class="required">
        <?php echo $form->labelEx($model, 'CodCliente');?>
        <?php
             $this->widget('zii.widgets.jui.CJuiAutoComplete',
                      array(
                       'id'=>'CodCliente',
                       'name'=>'Cliente', // Nombre para el campo de autocompletar
                       'model'=>$model,
                       'value'=>$model->CodCliente,
                       'source'=>$this->createUrl('venta/autocompletel'), // URL que genera el conjunto de datos
                       'options'=> array(
                         'showAnim'=>'fold',
                         'size'=>'30',
                         'minLength'=>'2', // Minimo de caracteres que hay que digitar antes de relizar la busqueda
                         'select'=>"js:function(event, ui) { 
                          $('#nombreCliente').val(ui.item.nombre); // HTML-Id del campo
                          $('#direccion').val(ui.item.direccion);
                          $('#telefono').val(ui.item.telefono);
                           }"
                         ),
                       'htmlOptions'=> array(
                        'size'=>40,
                        'placeholder'=>'Buscar ...',
                        'title'=>'Indique el producto.'
                        ),
                      )); 
        ?>
        <?php echo $form->error($model,'CodCliente'); ?>
    </div>
    </th>
    <th>
    <div class="required">
        <label>Cliente</label>
        <input type="text" id="nombreCliente"/>
    </div>
    </th>
    <th>
    <div class="required">
        <label>Direccion</label>
        <input type="text" id="direccion"/>
    </div>
    </th>
    <th>
    <div class="required">
        <label>Telefono</label>
        <input type="text" id="telefono"/>
    </div>
    </th>
    
    <th>
    <div class="required">
        <?php echo $form->labelEx($model, 'CodBodega');?>
        <?php echo $form->textField($model, 'CodBodega');?>
        <?php echo $form->error($model,'CodBodega'); ?>
    </div>
    </th>
    

    <div>
    <?php
    
    // see http://www.yiiframework.com/doc/guide/1.1/en/form.table
    // Note: Can be a route to a config file too,
    //       or create a method 'getMultiModelForm()' in the member model
 
    $memberFormConfig = array(
          'elements'=>array(
            'CodProducto'=>array(
                'type'=>'text',
                'maxlength'=>80,
                'class'=>'CodProducto',
            ),
            'Descripcion'=>array(
                'type'=>'zii.widgets.jui.CJuiAutoComplete',                
                'source'=>$this->createUrl('venta/autocomplete'),
                'options'=>array(
                    'showAnim'=>'fold',
                         'size'=>'80',
                         'minLength'=>'2', // Minimo de caracteres que hay que digitar antes de relizar la busqueda
                         'select'=>"js:function(event, ui) { 
                         var contador = parseInt($('#contador').html());
                         
                  
                         $('#Detalleventa_CodProducto').val(ui.item.id); // HTML-Id del campo
                         $('#Detalleventa_Precio').val(ui.item.precio);
                         
                         $('#Detalleventa_CodProducto'+contador).val(ui.item.id); // HTML-Id del campo
                         $('#Detalleventa_Precio'+contador).val(ui.item.precio);
                         
                         contador++;
                         alert (contador);
                         
                         $('#contador').html(contador);
                        
                         }",
                         
                        
                                      
                ),
                'htmlOptions'=> array(
                        'size'=>120,
                        'placeholder'=>'Buscar ...',
                        'title'=>'Indique el producto.'
                ),
                
               
            ),
            'Precio'=>array(
                'type'=>'text',
                'maxlength'=>120,
                'class'=>'Precio',
                
            ),  
            'Cantidad'=>array(
                'type'=>'text',
                //it is important to add an empty item because of new records
                'maxlength'=>120,
                'class'=>'Cantidad',
            ),
        ));
    
    $this->widget('ext.multimodelform.MultiModelForm',array(
            'id' => 'id_member', //the unique widget id
            'formConfig' => $memberFormConfig, //the form configuration array
            'model' => $member, //instance of the form model
            'tableView'=>true,
            //if submitted not empty from the controller,
            //the form will be rendered with validation errors
            'validatedItems' => $validatedMembers,
            'jsAfterNewId' => MultiModelForm::afterNewIdAutoComplete($memberFormConfig['elements']['Descripcion']),
           
                                            
            'addItemText' => 'Agregar',
            'removeText' => 'Quitar',
            'removeConfirm' => 'Desea quitar la fila seleccionada',
            //array of member instances loaded from db
            'data' => $member->findAll('NumVenta=:groupId', array(':groupId'=>$model->NumVenta)),
        ));
    ?>
        
            <th>
    <div class="required">
        <?php echo $form->labelEx($model, 'ForPago');?>
        <?php echo $form->dropDownList($model, 'ForPago', array('Debito', 'Credito', 'Efectivo', 'Cheque', 'Vale'));?>
        <?php echo $form->error($model,'ForPago'); ?>
    </div>
    </th>
    <th>
    <div class="required">
        <?php echo $form->labelEx($model, 'TotExento');?>
        <?php echo $form->textField($model, 'TotExento');?>
        <?php echo $form->error($model,'TotExento'); ?>
    </div>
    </th>
    
    <th>
    <div class="required">
        <?php echo $form->labelEx($model, 'TotDescuento');?>
        <?php echo $form->textField($model, 'TotDescuento');?>
        <?php echo $form->error($model,'TotDescuento'); ?>
    </div>
    </th>
    
    <th>
    <div class="required">
        <?php echo $form->labelEx($model, 'TotNeto');?>
        <?php echo $form->textField($model, 'TotNeto');?>
        <?php echo $form->error($model,'TotNeto'); ?>
    </div>
    </th>
    <th>
    <div>
        <?php echo $form->labelEx($model, 'TotIva');?>
        <?php echo $form->textField($model, 'TotIva');?>
        <?php echo $form->error($model,'TotIva'); ?>
    </div>
    </th>
    
    <th>
    <div>
        <?php echo $form->labelEx($model, 'TotImpuesto');?>
        <?php echo $form->textField($model, 'TotImpuesto');?>
        <?php echo $form->error($model,'TotImpuesto'); ?>
    </div>
    </th>
    
    <th>
    <div>
        <?php echo $form->labelEx($model, 'TotRetencion');?>
        <?php echo $form->textField($model, 'TotRetencion');?>
        <?php echo $form->error($model,'TotRetencion'); ?>
    </div>
    </th>
    
    <th>
    <div>
        <?php echo $form->labelEx($model, 'Total');?>
        <?php echo $form->textField($model, 'Total');?>
        <?php echo $form->error($model,'Total'); ?>
    </div>
    </th>
    </table>
    <div class="required buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>
 
    <?php $this->endWidget(); ?>
 
    </div><!-- form -->