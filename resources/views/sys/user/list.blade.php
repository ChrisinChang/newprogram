<?php

// dd($TPL);


$_index = 0;
$sDmoanHtml = "";


//btn_create_usertodomains


$_index = 0;


//aSysLv
$_index = 0;
$jsonSysLv = "{";
foreach( $TPL['aSysLv'] as $_key => $_val ){
  if( $_index != 0 ){
    $jsonSysLv .= ",";
  }
  $jsonSysLv .= '"'.$_key  .'": ' . '"'.$_val.'"';
  $_index++;
}
$jsonSysLv .= "}";


// aType
$_index = 0;
$jsonType = "{";
foreach( $TPL['aType'] as $_key =>  $_val ){
  if( $_index != 0 ){
    $jsonType .= ",";
  }
  $jsonType .= '"'.$_key  .'": ' . '"'.$_val.'"';
  $_index++;
}
$jsonType .= "}";

?>
@extends('sys.base')

@section('title')
Create Page
@stop




@section('jquery_script')

{{-- <script type="text/javascript" > 寓意標籤用--}}





    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
          
            
  
  $("#btn_create_sys").click( function(){
    //  console.dir( $("#input_form").serialize() );
        //  alert("{!! URL::route('Sysadmin.user.createUser', [] ) !!}");
        // return ;
        $.ajax({
          url: '{!! URL::route('Sysadmin.user.createUser', [] ) !!}',
          type: 'POST',
          //data: {
          //  user_name: $('#user_name').val()
          //},
          data:$("#input_form").serialize(),
          beforeSend:function(e){
            // l.start();
          },
          error: function(xhr) {
            alert('Ajax request 發生錯誤');
            // l.stop();
          },
          success: function(response) {
              //$('#msg_user_name').html(response);
              //$('#msg_user_name').fadeIn();
                //   l.stop();
              
              $jData = JSON.parse(response);
              
              /*
              {"akey":"","skey":"","svalue":"","core_type":"bad","core_msg":{"akey":["The akey field is required."],"skey":["The skey field is required."]}}
              */
              
              
              if( $jData.core_type == "bad" ){
                //alert( $jData.core_msg );
                
                //core_html
                
                //$.each( $jData.core_msg , function(i, item) {
                    //alert(item.PageName);
                //});
                $("#create_message_box").html( $jData.core_html ).show();
                
              }else{
                
                location.reload(location.href + "#ok");
              }
              
              
              //location.replace(location.href + "#ok");
       
          }
        });
  });

{{-- </script> --}}
@stop

@section('else_script')
{{-- <script type="text/javascript" > 寓意標籤用--}}


/***
Vue.directive('tolerious', {
            bind: function (value) {
                // console.log('bind');
                // console.dir( value);
                value.attributes.act.value = value.value;
            },
            update: function (value) {
              // console.dir(value.attributes.act.value);
                value.value = value.attributes.act.value;
                // console.dir( value.inputElement );
                
            },
            unbind: function () {
                console.log('unbind');
            }
        });
****/
var vm = new Vue({
    el: '#v_table',
    data: {
        rows: [
            //initial data
            @foreach ($TPL['aUserData'] as $_val )
              { 
                id: "{{ $_val['id'] }}" ,
                user_str: "{{ $_val['user_str'] }}" , 
                passwd: "{{ $_val['passwd'] }}" ,
                lv_id: "{{ $_val['lv_id'] }}" ,
                is_life: "{{ $_val['is_life'] }}" ,
                enable_time: "{{ $_val['enable_time'] }}" ,
                disable_time: "{{ $_val['disable_time'] }}" ,
                memo: "{{ $_val['memo'] }}" 
              },
            @endforeach
            // {qty: 5, description: "Something", price: 55.20, tax: 10},
            // {qty: 2, description: "Something else", price: 1255.20, tax: 20},
        ],
        total: 0,
        grandtotal: 0,
        taxtotal: 0,
        delivery: 40
    },
    
    
    methods: {
        saveRow: function (index , id ) {
            console.log( "A: index:" + index + " ,id:" + id);
            this.rows[index]['action'] = 'edit';
            // console.dir( this.rows[index] );
            // try {
            //     this.rows.splice(index + 1, 0, {});
            // } catch(e)
            // {
            //     console.log(e);
            // }
            try{
              axios.post('{!! URL::route('Sysadmin.user.editUser', [] ) !!}'
              ,this.rows[index]  )
              // , {title: this.title,commit: this.commit,})
              .then(function(response) {
                  alert('ok:' );
              })
              .catch(function(error) {
                  alert('error');
              });
            }catch(e){
              
            }
        },
        removeRow: function (index , id) {
            var self = this;
            this.rows[index]['action'] = 'delete';
            try{
              axios.post('{!! URL::route('Sysadmin.user.editUser', [] ) !!}'
              ,this.rows[index]  )
              // , {title: this.title,commit: this.commit,})
              .then(function(response) {
                  alert('delete ok' );
                  self.rows.splice(index, 1);
              })
              .catch(function(error) {
                  alert('error');
              });
            }catch(e){
              
            }
        },
        
        fn_updata_enable_time: function(index , id ) {
            console.log( "index:" + index + " ,id:" + id);
          console.log("click");
          console.dir( this );
          // this[0].dispatchEvent(new Event('change'));
          // this.rows.enable_time = $('#lang_switcher20' )[0].value;
        },
        fn_updata_disable_time: function(index , id ) {
            console.log( "C:index:" + index + " ,id:" + id);
            console.dir( this );
            // this[0].dispatchEvent(new Event('change'));
            // this.dispatchEvent(new Event('change'));
          
        }
    },
    
    
});



$( document ).ready(function() {
  
      $('.time_picker').daterangepicker({
          locale: {
              format: 'YYYY-MM-DD hh:mm:ss'
          },
          // autoUpdateInput: true,
          timePicker: true,
          timePickerIncrement: 10,
          singleDatePicker: true,
          // calender_style: "picker_1"
        }, function(start, end, label) {
          // console.log(start.toISOString(), end.toISOString(), label);
          var _tdd = start.format('YYYY-MM-DD hh:mm:ss');
          $(this).val(_tdd);

          var _act = this.element[0].attributes.act.value;
          

          $(this).val(_tdd).trigger("input");
          // $(this).parents( "tr" ).find(".c_" + _act).click();
          // var _input = $(this).parents( "<tr>" ).find(".c_" + _act);
          var _input = $(this.element[0]).parent('div').find(".c_" + _act);
          console.dir( this.element );
          _input.val(_tdd );
          // _input.val(_tdd ).trigger('change').click();
          try{
            const event = new Event('input', {cancelable: true,bubbles: true});
          // console.dir( _input );
          _input[0].dispatchEvent(event) ;
          }catch(e){
            
          }
          
          
         
        }
    );


});

{{-- </script> --}}
@stop


@section('content')  
  <!-- Page -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  
  
  <div class="page">
      
    <div class="page-header">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">系統管理</a></li>
        <li class="breadcrumb-item active">用戶管理</li>
      </ol>
      <h3 class="page-title">用戶管理</h3>
    </div>
    
    
    <div class="row">
        <div id="create_message_box" class="row row-lg" style="display:none" >xxx</div>
          
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>新增使用者 <small>...</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="x_content">
                    <br>
                    <form id="input_form" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">帳號 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" name="user_str" v-model="user_str"  required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">密碼 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" id="last-name" name="passwd"  v-model="passwd" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                 
                      
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">權限</label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <!--<select class="form-control" name="lv_id" v-model="lv_id"  >-->
                          <!--  <option value="1">1</option>-->
                            
                          <!--</select>-->
                            <input type="text"  v-model="lv_id" name="lv_id" required="required" class="form-control col-md-7 col-xs-12">
                          </div>
                          
                        </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">是否啟用</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div id="gender" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input type="radio" name="is_life" v-model="is_life" value="1" data-parsley-multiple="gender"> &nbsp; 啟用 &nbsp;
                            </label>
                            <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                              <input type="radio" name="is_life" -model="is_life"  value="0" data-parsley-multiple="gender"> &nbsp; 停用 &nbsp;
                            </label>
                            <!--<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">-->
                            <!--  <input type="radio" name="is_life" value="0" data-parsley-multiple="gender"> 停用-->
                            <!--</label>-->
                          </div>
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">啟用時間<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                              <input type="hidden"  class="c_enable_time" name="enable_time" v-model="row.enable_time" @click="fn_updata_enable_time(index , row.id)" />
                                    
                                <input type="text" name="xenable_time" v-model="enable_time" act="enable_time" class="form-control has-feedback-left active time_picker" value="" id="single_cal1" placeholder="" aria-describedby="inputSuccess2Status">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                               
                              </div>
                              
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">結束時間<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            
                            <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                              <input type="hidden"  class="c_disable_time" name="disable_time" v-model="row.disable_time" @click="fn_updata_disable_time(index , row.id)" />
                                    
                                <input type="text" name="xdisable_time" v-model="disable_time" act="disable_time" class="form-control has-feedback-left active time_picker" value="" id="single_cal1" placeholder="" aria-describedby="inputSuccess2Status">
                               <!--<input  type="hidden" class="form-control time_picker"  name="disable_time"   _v-model="row.disable_time" _v-tolerious:tt="row.disable_time"  act="disable_time"  />-->
                                   
                               <!-- <input type="text" name="xdisable_time" v-model="disable_time"  act="disable_time"  class="form-control has-feedback-left active time_picker" value="2016-01-23 11:24:00" id="single_cal1" placeholder="" aria-describedby="inputSuccess2Status">-->
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                               
                              </div>
                              
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">備註 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="memo" name="memo" v-model="memo" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                        </div>
                      </div>
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <!--<button type="submit" class="btn btn-primary">Cancel</button>-->
                          <div class="btn btn-success" id="btn_create_sys" v-on:click="click_addUser" >新增</div>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
    
    <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>使用者管理 <small>...</small></h2>

                    <div class="clearfix"></div>
                  </div>
      

              <div class="col-md-12 col-xs-12">
                
                
                    <div class=" table-responsive" id="v_table" >
                      <table id="table_user_list" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th style="display: none;"></th>
                            <th>帳號</th>
                            <th>密碼</th>
                            <th>權限</th>
                            <th>是否啟用</th>
                            <th>啟用時間</th>
                            <th>結束時間</th>
                            <th>備註</th>
                            <th></th>
                            
                          </tr>
                        </thead>
                        <tbody _v-sortable.tr="rows">
                             <tr v-for="(row, index) in rows">
                                <input type="hidden" v-model="row.id"/>
                                <td>
                                    @{{ index+1 }}
                                </td>
                                <td>
                                    @{{ row.user_str }}
                                </td>
                                <td>
                                    <input class="form-control" type="text" v-model="row.passwd" />
                                </td>
                                <td>
                                    <input class="form-control" type="text" v-model="row.lv_id" />
                                </td>
                                <td>
                                    <input class="form-control" type="text" v-model="row.is_life" />
                                </td>
                                <td>
                                  <div>
                                    <input class="c_enable_time" type="hidden" v-model="row.enable_time" @click="fn_updata_enable_time(index , row.id)" />
                                    <input class="form-control time_picker" type="text"   v-model="row.enable_time" act="enable_time"    />
                                  </div>
                                    
                                </td>
                                <td>
                                  <div>
                                    <input class="c_disable_time"  type="hidden"  v-model="row.disable_time" @click="fn_updata_disable_time(index , row.id)"  />
                                    <input class="form-control time_picker" type="text"    v-model="row.disable_time" act="disable_time"  />
                                  </div>
                                    
                                </td>
                                <td>
                                    <input class="form-control" type="text" v-model="row.memo" />
                                </td>
                                
                                <!--<td>-->
                                    <!--<input class="form-control text-right" v-model="row.price | currencyDisplay" number data-type="currency"/>-->
                                <!--</td>-->
                                <!--<td>-->
                                <!--    <select class="form-control" v-model="row.tax">-->
                                <!--        <option value="0">0%</option>-->
                                <!--        <option value="10">10%</option>-->
                                <!--        <option value="20">20%</option>-->
                                <!--    </select>-->
                                <!--</td>-->
                                <!--<td>-->
                                    <!--<input class="form-control text-right" :value="row.qty * row.price | currencyDisplay" v-model="row.total | currencyDisplay" number readonly />-->
                                    <!--<input type="hidden" :value="row.qty * row.price * row.tax / 100" v-model="row.tax_amount | currencyDisplay" number/>-->
                                <!--</td>-->
                                <td>
                                    <button class="btn btn-primary btn-xs" @click="saveRow(index , row.id)">儲存</button>
                                    <button class="btn btn-danger btn-xs" @click="removeRow(index , row.id)">移除</button>
                                </td>
                            </tr>



                        </tbody>
                      </table>

{{ $TPL['dbUserData']->links('pagination.default') }}
                    </div>
                 
                
              </div>
            </div>
          
    </div>
    </div>      
          
          
    
    
   
  </div>
  <!-- End Page -->
@stop