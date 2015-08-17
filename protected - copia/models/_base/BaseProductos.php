<?php

/**
 * This is the model base class for the table "productos".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Productos".
 *
 * Columns in table "productos" available as properties of the model,
 * and there are no model relations.
 *
 * @property string $Id
 * @property string $CodProducto
 * @property string $Descripcion
 * @property string $UniMedida
 * @property string $CanExistencia
 * @property string $PreCompra
 * @property string $PreVenta
 * @property string $CodProveedor
 *
 */
abstract class BaseProductos extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'productos';
    }

    public static function representingColumn() {
        return 'Descripcion';
    }

    public function rules() {
        return array(
            array('Id, CodProducto, Descripcion, UniMedida, CanExistencia, PreCompra, PreVenta, CodProveedor', 'required'),
            array('Id', 'length', 'max'=>20),
            array('CodProducto', 'length', 'max'=>40),
            array('Descripcion', 'length', 'max'=>50),
            array('UniMedida, CanExistencia, PreCompra, PreVenta, CodProveedor', 'length', 'max'=>10),
            array('Id, CodProducto, Descripcion, UniMedida, CanExistencia, PreCompra, PreVenta, CodProveedor', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'Id' => Yii::t('app', 'ID'),
                'CodProducto' => Yii::t('app', 'Cod Producto'),
                'Descripcion' => Yii::t('app', 'Descripcion'),
                'UniMedida' => Yii::t('app', 'Uni Medida'),
                'CanExistencia' => Yii::t('app', 'Can Existencia'),
                'PreCompra' => Yii::t('app', 'Pre Compra'),
                'PreVenta' => Yii::t('app', 'Pre Venta'),
                'CodProveedor' => Yii::t('app', 'Cod Proveedor'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('Id', $this->Id, true);
        $criteria->compare('CodProducto', $this->CodProducto, true);
        $criteria->compare('Descripcion', $this->Descripcion, true);
        $criteria->compare('UniMedida', $this->UniMedida, true);
        $criteria->compare('CanExistencia', $this->CanExistencia, true);
        $criteria->compare('PreCompra', $this->PreCompra, true);
        $criteria->compare('PreVenta', $this->PreVenta, true);
        $criteria->compare('CodProveedor', $this->CodProveedor, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
            'ActiveRecordRelation' => array(
                'class' => 'EActiveRecordRelationBehavior',
            ),
        ), parent::behaviors());
    }
}