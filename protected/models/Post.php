<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property string $author_name
 * @property string $title
 * @property string $contents
 * @property string $category
 */
class Post extends CActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, author_name, title, contents, category', 'required'),
			array('id', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, author_name, title, contents, category', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'post'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'author_name' => 'Author Name',
			'title' => 'Title',
			'contents' => 'Contents',
			'category' => 'Category',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('author_name', $this->author_name, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('contents', $this->contents, true);
		$criteria->compare('category', $this->category, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	public function beforeSave() {
		echo "string";
		if ($this->isNewRecord) {
			$this->created_at = time();
		}
		$this->updated_at = time();
		return parent::beforeSave();
	}

	public function updateColumns($column_value_array) {
		$column_value_array['updated_at'] = time();
		foreach ($column_value_array as $column_name => $column_value) {
			$this->$column_name = $column_value;
		}

		$this->update(array_keys($column_value_array));
	}

	public static function create($attributes) {
		$model = new Post;
		$model->attributes = $attributes;
		$model->save();
		return $model;
	}
}
