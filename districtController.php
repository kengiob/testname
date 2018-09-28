<?php

class districtController extends Controller
{
	function init() {
		parent::chkLogin();
	}
		
	public function actionIndex()
	{
		$model = lkup_district::search();
		$this->render('district', array('model'=>$model));
		//$this->render('department');
	}
	public function actionSearch()
	{
		//if(isset($_GET['ajax']) && isset($_GET['sort'])){
		if(isset($_GET['ajax']) && !isset($_POST['YII_CSRF_TOKEN'])){
			$keyword = Yii::app()->session['district_keyword'];
				$dep = Yii::app()->session['district_dep'];
		} else {
			$keyword = isset($_POST['keyword'])?addslashes(trim($_POST['keyword'])):'';	
				$dep = isset($_POST['dep'])?addslashes(trim($_POST['dep'])):'';	
			
				Yii::app()->session['district_keyword']=$keyword;	
				Yii::app()->session['district_dep']=$dep;				
		}
		$model = lkup_district::search($keyword,$dep);			
		$this->renderPartial('district', array('model'=>$model));
		
		
	}
	public function actionDepartmentdata(){
		
		$name="";
		$code="";
		$code_province="";
		$status1="";
		$code_amphur="";

		$id=isset($_POST['id'])?addslashes(trim($_POST['id'])):'';
		$data=lkup_district::getDepartment($id);
		foreach($data as $dataitem){
			
			$id=$dataitem['id'];
			$code=$dataitem['code_district'];
			$name=$dataitem['name_district'];
			$code_province=$dataitem['code_province'];
			$code_amphur=$dataitem['code_amphur'];
			$status1=$dataitem['status'];
			
		
		}
		echo CJSON::encode(array(
			'status' => 'success',
			'msg' => '',
			'id'=>$id,
			'code'=>$code,
			'name'=>$name,
			'code_province'=>$code_province,
			'code_amphur'=>$code_amphur,
			'status1'=>$status1
			));		

	}
	
	
	public function actionSavedata(){

		$model=new frm_district;		
		$model->id=isset($_POST['id'])?addslashes(trim($_POST['id'])):'';
		$model->code_district=isset($_POST['code_district'])?addslashes(trim($_POST['code_district'])):'';
		$model->name_district=isset($_POST['name_district'])?addslashes(trim($_POST['name_district'])):'';
		$model->code_province=isset($_POST['code_province'])?addslashes(trim($_POST['code_province'])):'';
		$model->code_amphur=isset($_POST['code_amphur'])?addslashes(trim($_POST['code_amphur'])):'';
		$model->status=isset($_POST['status'])?addslashes(trim($_POST['status'])):'';
	
		if($model->id==''){
			if($model->save_insert()) {
					echo CJSON::encode(array('status' => 'success','msg' => '',));		 
				} else {
					echo CJSON::encode(array('status' => 'error','msg' => Yii::app()->session['errmsg_dep'], ));		
						Yii::app()->session->remove('errmsg_dep');
				}
		}else{
			if($model->save_update()) {
					echo CJSON::encode(array('status' => 'success','msg' => '',));		 
				} else {
					echo CJSON::encode(array('status' => 'error','msg' => Yii::app()->session['errmsg_dep'], ));		
						Yii::app()->session->remove('errmsg_dep');	
					}	
				}
		}
	public function actionDeletedata(){

		$model=new frm_district;		
		$model->id=isset($_POST['id'])?addslashes(trim($_POST['id'])):'';
		
			if($model->save_delete()) {
					echo CJSON::encode(array('status' => 'success','msg' => '',));		 
				} else {
					echo CJSON::encode(array('status' => 'error','msg' => Yii::app()->session['errmsg_dep'], ));		
						Yii::app()->session->remove('errmsg_dep');
				}
	}
	
	public function actionAmphur(){
		//$name_amphur=array();
		//$code_amphur=array();
		$code_province=isset($_POST['code_province'])?addslashes(trim($_POST['code_province'])):'';
		
		$data=lkup_district::get_amphur($code_province);

		foreach($data as $dataitem){
			$name_amphur[]=$dataitem['name_amphur'];
			$code_amphur[]=$dataitem['code_amphur'];
			
			

		}
		//echo CJSON::encode(array('status' => 'success','msg' => Yii::app()->session['errmsg_sql'],));
		
echo CJSON::encode(array(
			'status' => 'success',
			'msg' => '',
			'name_amphur'=>$name_amphur,
			'code_amphur'=>$code_amphur
			
			));
		
	}
}