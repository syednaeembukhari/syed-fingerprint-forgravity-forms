<?php 

if ( ! function_exists( 'gfp_init' ) ) {
  function gfp_init() {
     
       // wp_enqueue_style( 'syedls-style', SYEDLS_URI . 'assets/jquery.modal.css' );
       // wp_enqueue_style( 'syedls-style2', SYEDLS_URI . 'assets/the-datepicker/the-datepicker.css' );
       // wp_enqueue_script( 'syedls-script', SYEDLS_URI . 'assets/jquery.modal.js', array( 'jquery' ), true );
      //  wp_enqueue_script( 'syedls-script2', SYEDLS_URI . 'assets/the-datepicker/the-datepicker.js', array( 'jquery' ), true );
     // fing();
     // wp_enqueue_style( 'syedls-style', SYEDGFP_URI . 'fontawesome/css/all.css' );
      
  }
}
$_gform_setting_fingureprint=0;
if ( ! function_exists( 'gfp_admin_scripts' ) ) {
  function gfp_admin_scripts() {   
    //echo "<link rel='stylesheet' id='syedls-style-admin' href='".SYEDGFP_URI . "fontawesome/css/all.css' />";  
   echo '<link  rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>'; 

    
  }
}
add_action( 'init', 'gfp_init' );
add_action( 'admin_enqueue_scripts', 'gfp_admin_scripts' );
add_filter( 'gform_pre_render', 'syedgf_script_form_load' );
function syedgf_script_form_load( $form){
  $GLOBALS['gformid']= $form['id'];
  echo '<script> var  tip= "'.syedgf_getUserIP().'"; var gformid="'.$GLOBALS['gformid'].';"</script>';
  if($GLOBALS['gformid']>0){
    $_gform_setting_fingureprint= get_option( '_gform_setting_fingureprint_'.$GLOBALS['gformid'], 0 );   
    wp_enqueue_script( 'fpsyedls-script', SYEDGFP_URI . 'public/vendors/clientjs-master/dist/client.min.js', array( 'jquery' ), true );
    wp_enqueue_script( 'fpsyedls-script3', SYEDGFP_URI . 'public/js/gravity_fingerprints.js?1.0', array( 'fpsyedls-script' ), true );
  }
   
  return $form;
}
add_filter( 'gform_post_submission', 'syedgf_post_submission_load', 10, 2 );
function syedgf_post_submission_load( $entry, $form ) {
  //echo '<pre>'; print_r( $_POST); echo '</pre>';
  $ip = $entry['ip'];
  $GLOBALS['ip']=$ip ;
}

add_action('gform_loaded','syedgf_scripts',10,0);
function syedgf_scripts(){
   
  //echo '<pre>'; print_r($_REQUEST['id']); echo '-here-</pre>';
  $_gform_setting_fingureprint= get_option( '_gform_setting_fingureprint_'.$_REQUEST['id'], 0 );
  if($_gform_setting_fingureprint > 0)
    GF_Fields::register( new syedgf_Field_FP() );

  add_action( 'gform_entry_detail_sidebar_middle', 'add_sidebar_text_middle', 10, 2 );

   
}
 
 add_filter( 'gform_form_tag', 'gform_form_tag_autocomplete', 11, 2 );
function gform_form_tag_autocomplete( $form_tag, $form )
{
  if ( is_admin() ) return $form_tag;
  if ( GFFormsModel::is_html5_enabled() )
  {
    $form_tag = str_replace( '>', ' autocomplete="off">', $form_tag );
  }
  return $form_tag;
}
// add a custom menu item to the Form Settings page menu
add_filter( 'gform_form_settings_menu', 'fingerprint_form_settings_menu_item' );
function fingerprint_form_settings_menu_item( $menu_items ) {
  
    $menu_items[] = array(
        'name' => 'fingerprint_form_settings_page',
        'label' => __( 'Fingerprint' ),
        'icon' => 'fas fa-fingerprint'
        );
  
    return $menu_items;
}
  
// handle displaying content for our custom menu when selected
add_action( 'gform_form_settings_page_fingerprint_form_settings_page', 'fingerprint_form_settings_page' );
function fingerprint_form_settings_page() {
  if(isset($_REQUEST['fingerprintsettings_save']) && $_REQUEST['fingerprintsettings_save']==1)
  {
    update_option( '_gform_setting_fingureprint_'.$_REQUEST['id'], $_REQUEST['_gform_setting_fingureprint']  , 0);
  }
  $_gform_setting_fingureprint=get_option( '_gform_setting_fingureprint_'.$_REQUEST['id']);
  if($_gform_setting_fingureprint==0)
    update_option( '_gform_setting_fingureprint_'.$_REQUEST['id'], 1 , 1);
  $_gform_setting_fingureprint=get_option( '_gform_setting_fingureprint_'.$_REQUEST['id'] );
    GFFormSettings::page_header();
    
    echo '<div class="gform-settings-panel">
          <header class="gform-settings-panel__header" >
            <h4 class="gform-settings-panel__title">Fingerprint Settings</h4>
          </header>
          <div class="gform-settings-panel__content" style="min-height:400px">
              <form   method="post" > 
                  <input type="hidden" name="gformid" value="'.$_REQUEST['id'].'">
                  <input type="hidden" name="fingerprintsettings_save" value="1">
                    <span class="gform-settings-input__container">
                      <div  class="gform-settings-choice">
                        <input type="radio" name="_gform_setting_fingureprint" value="1" '.($_gform_setting_fingureprint==1?' checked="checked"':'').' id="_gform_setting_fingureprint_1">
                        <label  > <span>Enable </span> </label>
                      </div>
                      <div   class="gform-settings-choice">
                        <input type="radio" name="_gform_setting_fingureprint" value="-1" '.($_gform_setting_fingureprint==-1?' checked="checked"':'').'   id="_gform_setting_fingureprint_0">
                        <label  > <span>Disable </span> </label>
                      </div>
                    </span>
                      <br/>
                      <span class="gform-settings-input__container">

                      <div  class="gform-settings-choice">
                         
                        <label  > <span> </span> </label>
                      </div>
                      <div   class="gform-settings-choice">
                        <label  > <span>  </span> </label>
                      </div>

                    </span>




                      <span class="gform-settings-input__container">
                      <button type="submit" class="button"> Save </button>
                      </span>
              </form>
            </div>
          </div>


        ';
  
  GFFormSettings::page_footer();
  
}

function syedgf_getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
      $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
      $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


add_action( 'gform_after_submission', 'syedgf_footernotes', 10, 2 );
function syedgf_footernotes( $entry, $form ) {
 
    //getting post
    $post = $entry['fornotes'] ;
    //print_r($entry);
    //changing post content
    if(isset($_POST['fornotes']))
    {
      $entry_id=$entry['id'];
      $user_id=0;
      $user_name='system';
      $note=$_POST['fornotes'];
      $note_type='String';
      $_gform_setting_fingureprint=get_option( '_gform_setting_fingureprint_'.$form['id'] );
      if($_gform_setting_fingureprint)
      GFFormsModel::add_note($entry_id, $user_id, $user_name, $note , $note_type);
    }
 
    //updating post
   // die; 
}






if ( ! class_exists( 'GFForms' ) ) { die(); }

class  syedgf_Field_FP extends GF_Field {

  public $type = 'FingerPrint';
  public $txtdomain='txtdomain';
 
  public function get_form_editor_button() {
      return [
        'group' => 'advanced_fields',
        'text'  => $this->type, //$this->get_form_editor_field_title(),
        'label'  =>  'Fingerprint' ,
        'icon'  => '',
        'visibilty'=>'hidden'
      ];
    } 
   
  public function get_form_editor_field_settings() {
    return [
      //'description_setting' ,
      'label_setting',
      'visibility_setting'
       
    ];
  }
  public function get_field_label($form, $value = '', $entry = null) {
      $field_id="input_$id" ;
       $field_label = parent::get_field_label($form, $value);
      if ($this->is_form_editor()) { 

        return parent::get_field_label($form,$value,$entry );
      }else{
        
       return '';
      }
       if($field_label==$this->type)
       {
        return;
       }
       
      // .. Rest of code for frontend and edit entry here...
  } 
  public function get_field_input($form, $value = '', $entry = null) {
      if ($this->is_form_editor()) {
        return '';
      }
      $form_id     = $form['id'];
      $id          = (int) $this->id;
      //$field_id    = $is_entry_detail || $is_form_editor || 0 === $form_id ? "input_$id" : 'input_' . $form_id . "_$id";
      $field_id="input_$id" ;
      $v='style="display:none; visibilty:hidden"';
       
      return '
        <div '.$v.'  ><textarea name="'.$field_id.'" id="'.$field_id.'" class="fingerprintitem" '.$v.' ></textarea></div>
      ';
       
      // .. Rest of code for frontend and edit entry here...
  }
/*
    public function get_value_save_entry($value, $form, $input_name, $lead_id, $lead) {
      if (empty($value)) {
        $value = '';
      } else {
       $value= stripslashes($value) ;  
       // $value = serialize($table_value);
      }
      //print_r($value);
      return $value;
    }
    */
    public function get_value_entry_detail($value, $currency = '', $use_text = false, $format = 'html', $media = 'screen') {
      //$value = maybe_unserialize($value);   
      //if (empty($value)) {
       // return '';
     // }
      $str =  $value;
      return $str;
    }
     
     public function get_value_save_entry( $value, $form, $input_name, $lead_id, $lead ) {
    if ( empty( $value ) ) {

      return '';

     
    } else {

      return $this->sanitize_entry_value( $value, $form['id'] );

    }
  }

  public function register_meta_box( $meta_boxes, $entry, $form ) {
    $fields = GFAPI::get_fields_by_type( $form, array( 'FingerPrint' ) );
 
      if ( ! empty( $fields ) ) {
          $meta_boxes['gf_fingerPrint'] = array(
              'title'    => esc_html__( 'Fingerprint' ),
              'callback' => array( $this, 'add_fingerPrint_meta_box' ),
              'context'  => 'side',
          );
      }
   
      return $meta_boxes;
  }
  public function get_form_editor_inline_script_on_page_render() {
 
    // set the default field label for the field
    $script = sprintf( "function SetDefaultValues_%s(field) {field.label = '%s';}", $this->type, $this->get_form_editor_field_title() ) ;
 
    return $script;
  }

}

 
function add_sidebar_text_middle( $form, $entry ) {
    //echo '<pre>'; echo print_r($entry); echo '</pre>';
    $data='';
    foreach ($entry as $i=>$v)
    {
      if(strpos($v, 'browserData') !== false){
        $data=$v;
        break;
      }
    }
    if($v!='')
      $data=json_decode($data);
    if(isset($data->fingerprint)){
      //echo "<div class='stuffbox'><h3>Fingerprint</h3><div class='inside'> ".$data->fingerprint." <br/></div></div>";

      echo '<div id="side-sortables2" class="meta-box-sortables ui-sortable"><div id="submitdiv2" class="postbox ">
            <div id="fingerprintsec" class="postbox" style="border: none;box-shadow: none;">
              <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle">Fingerprint</h2>
                <div class="handle-actions hide-if-no-js">
                  <button type="button" class="handle-order-higher" aria-disabled="false" aria-describedby="fingerprintsec-handle-order-higher-description"><span class="screen-reader-text">Move up</span><span class="order-higher-indicator" aria-hidden="true"></span></button>
                  <span class="hidden" id="fingerprintsec-handle-order-higher-description">Move Fingerprint box up</span>


                  <button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="fingerprintsec-handle-order-lower-description">
                    <span class="screen-reader-text">Move down</span>
                    <span class="order-lower-indicator" aria-hidden="true"></span>
                  </button>
                  <span class="hidden" id="fingerprintsec-handle-order-lower-description">Move Fingerprint box down</span>
                  <button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: notifications</span><span class="toggle-indicator" aria-hidden="true"></span></button>
                </div>
              </div>
              <div class="inside" style="padding:12px">
                 <b>'.$data->fingerprint.'</b>  
              </div>
            </div></div></div><style>.entry-view-field-value{word-break: break-all !important;}</style>';


    }
    
}
 

add_action( 'gform_entry_detail', 'add_to_details', 10, 2 );
function add_to_details( $form, $entry ) {
     $is=false;
     $isv='';
     $id=0;
     foreach ( $form['fields'] as $field ) {
     // print_r($field);
      if( strtolower($field->type)=="fingerprint"){
        $is=true;
        $id=$field->id;
        $isv=$entry[$id];
        //echo '<pre>';print_r($field);echo '</pre>';
      }
    } //echo '<pre>';print_r($entry);echo '</pre>';
 

    if ($is){
        echo '<table class="entry-details-table " cellspacing="0">
                <tbody>
                <tr>
                    <td colspan="2" class="entry-view-field-value">
                    <a href="javascript:void(0)" onclick="myFunction()" class="button">Copy Fingerprint</a>
                    <textarea style="display:none; visibilty:hidden" id="myInput">'.$isv.'</textarea>
                    </td>
                </tr>
                </tbody>
              </table>
              <script>function myFunction() {
                var copyText = document.getElementById("myInput");
                copyText.select();
                copyText.setSelectionRange(0, 99999);  
                navigator.clipboard.writeText(copyText.value);
                alert("Copied to clipboard ");
            } </script>';
    }
    
}
 