var dealerQCDatatable = {
	initiate: function() {
                var GETSTATUS = 1;
		var cropContainerPreload='';
		var slider;
		var sliderFlag = '1';
		var sliderNextCount;
		var gotoSlideFlag ;
		var checkFinishFlag ='1';
		var $image ='';
		$(document).ready(function() {
			TableData.init();
			FormElements.init();			 
			Common.toastr();
			dealerQCDatatable.dataTable();
                        dealerQCDatatable.docuSigndataTable();
			dealerQCDatatable.exportQcReport();
                        dealerQCDatatable.exportDocuSignReport();
			dealerQCDatatable.qcListFilter();
                        dealerQCDatatable.docuSignListFilter();
			dealerQCDatatable.qcResetFilter();
                        dealerQCDatatable.docuSignResetFilter();
			dealerQCDatatable.qcReportPopup();
			dealerQCDatatable.qcCropImage();
			dealerQCDatatable.getModelList();
			dealerQCDatatable.getVersionList();
			dealerQCDatatable.getFuelTransType();
			dealerQCDatatable.validationOnQcPanel();
			dealerQCDatatable.rotateImageOnQcPanel();
                        dealerQCDatatable.popupFinDocuSign();
                        dealerQCDatatable.forceDownloadDocuSign();
	
		});
		dealerQCDatatable.getDataByAjax();
	},
        forceDownloadDocuSign : function(){
            $(document).on("click","#docusign_download",function(e){
                var vccId       =   $(this).attr("cert-id");
                var imageName   =   $(this).attr("docusign_name");
                var mainPath    =   GPATH_DIR_PATH +'assets/data/pdf/pdf_fin_docusign/'+imageName;
                var filePath = GPATH_BASE_REL+'reports/download?path='+mainPath+'&deleteFlag=0';
                Common.downloadPopUp(filePath);                
            });
        },
        popupFinDocuSign : function(){
            $(document).on("click","#open_btn",function(e){
                var vccId   =   $(this).attr("cert-id");
                $.FileDialog({multiple: true}).on('files.bs.filedialog', function(ev) {
                    var files = ev.files;
                    var imageName = '';
                    var imageContent = '';
                    var imageContentOrg = '';
                   
                    if(files.length>1){
                            alert('More than 1 file is not allowed');
                    }else { 
                        var text = "";
                        files.forEach(function(f) {
                            var keys = [];
                            for (var key in f) {
                                keys.push(key);
                            }
                            imageName = f.name;
                            imageContent = f.content;
                            
                        });

                       	$.ajax({
				type: "POST",
				url:'ajax',
				data:'name=uploadFinDocuSign&imageName='+imageName+'&imageContent='+imageContent+'&vcc_id='+vccId,            
                                success: function(msg){
                                    var objReturn = jQuery.parseJSON(msg);
                                    if(objReturn.status==true){
                                        Common.hideOverlay();                                        
                                        $('.doqcedit'+vccId).after( "&nbsp;&nbsp;<label class='label label-success'>Done</label>" );
                                        $('.findownload'+vccId).remove('.findownload'+vccId);
                                        $('.finupload'+vccId).remove('.finupload'+vccId);
                                        $('.docusign_tag'+vccId).html('Yes');
                                        $('.docusign_tag'+vccId).removeClass('label-danger');
                                        $('.docusign_tag'+vccId).addClass('label-success');
                                        
                                        toastr['success']('Image Uploaded Successfully', "success");
                                    }else{
                                        Common.hideOverlay();
                                        toastr['error'](objReturn.msg, "error");
                                    }
                                },
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					Common.hideOverlay();
					toastr['error'](errorThrown, "error");
				}
			});
                    }
                }).on('cancel.bs.filedialog', function(ev) {
                    $("#output").html("Cancelled!");
                });
            }); 
        },
	exportQcReport : function(){
            $("#export_dealerQC").click(function() {
                var list_flag       = $("#listFlag").val();
		var ce_name         = $("#ce_name").val();
		var dealer_name     = $("#dealer_name").val();
		var city_name       = $("#city_name").val();
		var reg_no          = $("#reg_no").val();
		var ce_status       = '';//$("#ce_status").val();
		var date_from       = $("#date_from").val();
		var date_to         = $("#date_to").val();
		var owner_in_prg    = $("#owner_in_prg").val();
		var invt_status     = $("#invt_status").val();
		var inspection_status= $("#inspection_status").val();

                $.ajax({
                    type    : "GET",
                    url     :'ajax',
                    data    :'name=DealerQcList&list_flag='+list_flag+'&ce_name='+ce_name+'&dealer_name='+dealer_name+'&city_name='+city_name+'&reg_no='+reg_no+'&ce_status='+ce_status+'&date_from='+date_from+'&date_to='+date_to+'&owner_in_prg='+owner_in_prg+'&invt_status='+invt_status+'&reportFlag=1&inspection_status='+inspection_status,            
                    success: function(msg){                                                      
                            if(msg!=''){
                                var filePath = GPATH_BASE_REL+'reports/download?path='+msg+'&deleteFlag=1';
                                Common.downloadPopUp(filePath);
                            }else{
                                toastr['error']('Error in exporting list!', "error");
                            }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr['error'](errorThrown, "error");
                    }
                });
            }); 
        },
       exportDocuSignReport : function(){
            $("#export_docusign").click(function() {
                var list_flag       = $("#listFlag").val();
		var ce_name         = $("#ce_name").val();
		var dealer_name     = $("#dealer_name").val();
		var city_name       = $("#city_name").val();
		var reg_no          = $("#reg_no").val();
		var ce_status       = '';//$("#ce_status").val();
		var date_from       = $("#date_from").val();
		var date_to         = $("#date_to").val();
		var owner_in_prg    = $("#owner_in_prg").val();
		var invt_status     = $("#invt_status").val();
		var inspection_status= $("#inspection_status").val();
                var rc_status       = $("#rc_status").val();

                $.ajax({
                    type    : "GET",
                    url     :'ajax',
                    data    :'name=DocuSignList&list_flag='+list_flag+'&ce_name='+ce_name+'&dealer_name='+dealer_name+'&city_name='+city_name+'&reg_no='+reg_no+'&ce_status='+ce_status+'&date_from='+date_from+'&date_to='+date_to+'&owner_in_prg='+owner_in_prg+'&invt_status='+invt_status+'&reportFlag=1&inspection_status='+inspection_status+'&rc_status='+rc_status,            
                    success: function(msg){                                                      
                            if(msg!=''){
                                var filePath = GPATH_BASE_REL+'reports/download?path='+msg+'&deleteFlag=1';
                                Common.downloadPopUp(filePath);
                            }else{
                                toastr['error']('Error in exporting list!', "error");
                            }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr['error'](errorThrown, "error");
                    }
                });
            }); 
        },
	rotateImageOnQcPanel: function() {	
		$(document).on("click",".imageRotateContainer",function(e){
			var rotateTagId = $(this).attr('id');
			var rotateArray = rotateTagId.split('-');
			
			if(rotateArray.length=='2'){
				var imageElemId = 'imageCont-'+rotateArray[1];
			}else if(rotateArray.length=='3'){
				var imageElemId = 'imageCont-'+rotateArray[1]+'-'+rotateArray[2];
			}

			var imageElemSrc = $('#'+imageElemId).attr('img-path');
			var imageElemAutoIncrId = $('#'+imageElemId).attr('img-id');
			var imageElemSrcUrl = $('#'+imageElemId).attr('src');
			var imageElemName = $('#'+imageElemId).attr('img-name');
			var imageElemCertId = $('#'+imageElemId).attr('cert-id');
			var imageElemType = $('#'+imageElemId).attr('img_type');
			var serImgPathTemp =imageElemSrc;
			Common.showOverlay();
			$.ajax({
				type: "POST",
				url:'/stockqc/rotateimage',
				data:'qcRotateImage=qcRotateImage&imageElemSrc='+imageElemSrcUrl+'&imagePath='+imageElemSrc+'&imageId='+imageElemAutoIncrId+'&imageName='+imageElemName+'&certId='+imageElemCertId+'&imgType='+imageElemType,            
					success: function(objReturn){
						//var objReturn = jQuery.parseJSON(msg);
						if(objReturn.status==true){
							Common.hideOverlay();
							d = new Date();
							$('#'+imageElemId).attr("img-name", objReturn.imageName);
							$('#'+imageElemId).attr("src", objReturn.url+"?"+d.getTime());
							toastr['success']('Image Rotated Successfully', "success");			
						}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					Common.hideOverlay();
					toastr['error'](errorThrown, "error");
				}
			});
		});	
	},
		
	
	validationOnQcPanelField : function() {
		var current = slider.getCurrentSlide();
		var total = slider.getSlideCount();
		var acCurrent = current;
		current = current+1;
		var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
		var checkboxAll ="questionN_"+selSliderId;
		var checkTickFlag =false;
		$("input."+checkboxAll+"[type='checkbox']").each(function () {
			if($(this).is(":checked") && $(this).attr("data-otherval")=='Other'){
				var otherTextId = "otherText_"+selSliderId;
				if($('.'+otherTextId).val()=='' || $('.'+otherTextId).val()=='null' || $('.'+otherTextId).val()==undefined){
					toastr['info']('Other Reason cann\'t left Blank!', "info");
					checkFinishFlag ='0';
				}
			}
		});

		if(selSliderId=='7'){//Odometer Reading
			var odometerId = "odometer_reading_"+selSliderId;
			if($('#'+odometerId).val()=='' || $('#'+odometerId).val()=='null' || $('#'+odometerId).val()==undefined){
					toastr['info']('Odometer reading cann\'t left Blank!', "info");
					checkFinishFlag ='0';					
				}
		}

		if(selSliderId=='9'){//Odometer Reading

		}
		
		if(selSliderId=='9'){//ABC pedal

		}
		
		if(selSliderId=='14'){//Boot/Dicky

		}
		
		if(selSliderId=='21'){//insurance
			var InsTypeId = "insurance_type_"+selSliderId;
			if($('#'+InsTypeId).val()=='' || $('#'+InsTypeId).val()=='null' || $('#'+InsTypeId).val()==undefined || $('#'+InsTypeId).val()=='0'){
				toastr['info']('Insurance Type cann\'t left Blank!', "info");
				checkFinishFlag ='0';			
			}
			
			var insCarHypoVal = "car_under_hypothecation_"+selSliderId;
			if(insCarHypoVal=='Yes'){
				var InsHypoFinaName = "financier_name_"+selSliderId;
				if($('#'+InsHypoFinaName).val()=='' || $('#'+InsHypoFinaName).val()=='null' || $('#'+InsHypoFinaName).val()==undefined || $('#'+InsHypoFinaName).val()=='0'){
					toastr['info']('Hypothecation Bank Name cann\'t left Blank!', "info");
					gotoSlideFlag = acCurrent;						
				}
			}
		}
		
		if(selSliderId=='22'){//RC
			var chassis_no = "chassis_no_"+selSliderId;
			var engine_no = "engine_no_"+selSliderId;
			var trans_type = "trans_type_"+selSliderId;
			
			if($('#'+chassis_no).val()=='' || $('#'+chassis_no).val()=='null' || $('#'+chassis_no).val()==undefined || $('#'+chassis_no).val()=='0'){
				toastr['info']('Chassis Number cann\'t left Blank!', "info");
				checkFinishFlag ='0';				
			}
			if($('#'+engine_no).val()=='' || $('#'+engine_no).val()=='null' || $('#'+engine_no).val()==undefined || $('#'+engine_no).val()=='0'){
				toastr['info']('Engine No cann\'t left Blank!', "info");
				checkFinishFlag ='0';
			}
			if($('#'+trans_type).val()=='' || $('#'+trans_type).val()=='null' || $('#'+trans_type).val()==undefined || $('#'+trans_type).val()=='0'){
				toastr['info']('Transmission Type cann\'t left Blank!', "info");
				gotoSlideFlag = acCurrent;						
			}
			
			var insCarHypoId = "car_under_hypothecation_"+selSliderId;
			var insCarHypoVal = $('#'+insCarHypoId).val();
			
			if(insCarHypoVal=='Yes'){
				var InsHypoFinaName = "financier_name_"+selSliderId;
				if($('#'+InsHypoFinaName).val()=='' || $('#'+InsHypoFinaName).val()=='null' || $('#'+InsHypoFinaName).val()==undefined || $('#'+InsHypoFinaName).val()=='0'){
					toastr['info']('Hypothecation Bank Name cann\'t left Blank!', "info");
					gotoSlideFlag = acCurrent;						
				}
			}
		}
		
		if(selSliderId=='23'){//pencil/vinplate
			var chassis_no = "chassis_no_"+selSliderId;
			var engine_no = "engine_no_"+selSliderId;
			if($('#'+chassis_no).val()=='' || $('#'+chassis_no).val()=='null' || $('#'+chassis_no).val()==undefined || $('#'+chassis_no).val()=='0'){
				toastr['info']('Chassis Number cann\'t left Blank!', "info");
				checkFinishFlag ='0';				
			}
			if($('#'+engine_no).val()=='' || $('#'+engine_no).val()=='null' || $('#'+engine_no).val()==undefined || $('#'+engine_no).val()=='0'){
				toastr['info']('Engine No cann\'t left Blank!', "info");
				checkFinishFlag ='0';				
			}
		}
	},
	
	validationOnQcPanel: function() {	
		$(document).on("click",".questionN",function(e){
			var qTagIs = $(this).attr('data-tagid');
			var qElementId = $(this).attr('id');

			// Auto check based on check box.
			var checkboxAll ="questionN_"+qTagIs;
			var imagesatId ="imageSatisfactionY"+qTagIs;
			var imageNotsatId ="imageSatisfactionN"+qTagIs;
			
			var checkTickFlag =false;
			$("input."+checkboxAll+"[type='checkbox']").each(function () {
				if($(this).is(":checked")){
					checkTickFlag =true;
				}
			});

			if(checkTickFlag==true){
				jQuery("#"+imagesatId).prop("checked", false);
				jQuery("#"+imageNotsatId).prop("checked", true);
			}else{
				jQuery("#"+imagesatId).prop("checked", true);
				jQuery("#"+imageNotsatId).prop("checked", false);
			}
		});
		
		$(document).on("click",".questionY",function(e){
			var qTagIs = $(this).attr('data-tagid');
			var qElementId = $(this).attr('id');
			var otherTextBoxClass = "otherText_"+qTagIs;
			$('.'+otherTextBoxClass).hide();
			// Auto check based on check box.
			var checkboxAll ="questionN_"+qTagIs;
			jQuery('.'+checkboxAll).prop('checked', false);
		});
		
		$(document).ready(function() {
			// On Change of insurance Type.
			$(document).on("change","#insurance_type_21",function(e){
				var insVal21 = $('#insurance_type_21').val();
				if(insVal21=='Expired' || insVal21=='Not Available'){
					$('#insurance_validity_date_21').val('');
					$('#insurance_validity_date_21').attr('disabled',true);
				}else if(insVal21=='' || insVal21=='0'){
					$('#insurance_validity_date_21').val('');
					$('#insurance_validity_date_21').attr('disabled',true);
				}else{
					$('#insurance_validity_date_21').attr('disabled',false);
				}
			});
			
			// On Change of Vehicle Under Hypothetication.
			$(document).on("change","#car_make_22",function(e){
				var carHypoVal21 = $('#car_make_22').val();
				if(carHypoVal21=='' || carHypoVal21=='0'){
					$('#car_model_22').attr('disabled',true);
					$('#car_version_22').attr('disabled',true);
				}else{
					$('#car_model_22').attr('disabled',false);
					$('#car_version_22').attr('disabled',false);
				}
			});
			
			// On Change of Vehicle Under Hypothetication.
			$(document).on("change","#car_under_hypothecation_21",function(e){
				var carHypoVal21 = $('#car_under_hypothecation_21').val();
				if(carHypoVal21=='Yes'){
					$('#financier_name_21').attr('disabled',false);
				}else{
					$('#financier_name_21').val('');
					$('#financier_name_21').attr('disabled',true);
				}
			});
			
			// On Change of Vehicle Under Hypothetication.
			$(document).on("change","#car_under_hypothecation_22",function(e){
				var carHypoVal21 = $('#car_under_hypothecation_22').val();
				if(carHypoVal21=='Yes'){
					$('#financier_name_22').attr('disabled',false);
				}else{
					$('#financier_name_22').val('');
					$('#financier_name_22').attr('disabled',true);
				}
			});
			
			// On Change of CNG/LPG Fitment Type.
			$(document).on("change","#cng_lpg_fitment_22",function(e){
				var cngLpgFitmetTypeId = "cng_lpg_fitment_22";
				var cngLpgFitmetTypeVal = $('#'+cngLpgFitmetTypeId).val();
				var cngLpgFtimetEndorseRcId = "cng_lpg_fitment_endorsement_rc_22";
				var cngLpgFtimetRemovalId = "cng_lpg_removal_22";
				var fuel_type_22	=	$('#fuel_type_22').val();
				
				if(fuel_type_22=='Petrol' && cngLpgFitmetTypeVal=='Outside Fitment'){
					$("#"+cngLpgFtimetEndorseRcId+" option[value='Not Applicable']").remove();
				}

				if(cngLpgFitmetTypeVal=='Not Applicable'){
				
					$('#'+cngLpgFtimetEndorseRcId).val('Not Applicable').trigger('change');
					$('#'+cngLpgFtimetRemovalId).val('Not Applicable').trigger('change');
					$('#'+cngLpgFtimetEndorseRcId).attr('disabled',true);
					$('#'+cngLpgFtimetRemovalId).attr('disabled',true);
					
				}else if(cngLpgFitmetTypeVal=='' || cngLpgFitmetTypeVal=='undefined' || cngLpgFitmetTypeVal=='0'){
					$('#'+cngLpgFtimetEndorseRcId).val('0').trigger('change');
					$('#'+cngLpgFtimetRemovalId).val('0').trigger('change');
					$('#'+cngLpgFtimetEndorseRcId).attr('disabled',true);
					$('#'+cngLpgFtimetRemovalId).attr('disabled',true);
				}else{
					$('#'+cngLpgFtimetEndorseRcId).attr('disabled',false);
					$('#'+cngLpgFtimetRemovalId).attr('disabled',false);
				}
			});
			
		});
		
	},

	getDataByAjax: function() {
            
                // Space Should not allow in these input fields.
                $(function() {
                    $('#chassis_no_22, #engine_no_22,#chassis_no_23, #engine_no_23').on("focus focusout", function() {
                        var dest = $(this);
                        dest.val(dest.val().split(" ").join("")); 
                    });
                });
		// Setting Next Previous Hit Button Flag.
		$(document).on("click",".doqcele",function(e){
			//$(this).hide();
			//window.open('http://example.com/url');
		});	
		// Setting Next Previous Hit Button Flag.
		$(document).on("click",".slide-prev",function(e){
			$('#nextprevflag').val('1');
		});
		// Setting Next Previous Hit Button Flag.
		$(document).on("click",".slide-next",function(e){
			$('#nextprevflag').val('0');
		});

		// Qc Panel Activity on Other TextBox
		$(document).on("click",".questionN",function(e){
			var qTagIs = $(this).attr('data-tagid');
			var qOtherVal = $(this).attr('data-otherval');
			var otherTextBoxClass = "otherText_"+qTagIs;
			if(qOtherVal=='Other'){
				$('.'+otherTextBoxClass).val('');
				$('.'+otherTextBoxClass).toggle();
			}		
		});
		
		// Qc Panel Submit/Finish Request
		$(document).on("click",".bx-slider-finish",function(e){
			var checkFinishFlag ='1';
			var current = slider.getCurrentSlide();
			var acCurrent = current;
			current = current+1;
			var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
			if(selSliderId=='1'){//Odometer Reading
                                var regnoId = "field_regno";

                                if($('#'+regnoId).val()=='' || $('#'+regnoId).val()=='null' || $('#'+regnoId).val()==undefined){
                                    checkFinishFlag ='0';
                                    Common.addErrorParams('#'+regnoId);
                                    toastr['info']('Reg No cann\'t left Blank!', "info");	
                                    gotoSlideFlag = acCurrent;

                                }else{
                                    Common.removeErrorParams('#'+regnoId);
                                }
                            }
                            if(selSliderId=='12'){//Odometer Reading
                                var odometerId = "field_km";

                                if($('#'+odometerId).val()=='' || $('#'+odometerId).val()=='null' || $('#'+odometerId).val()==undefined){
                                    checkFinishFlag ='0';
                                    Common.addErrorParams('#'+odometerId);
                                    toastr['info']('Odometer reading cann\'t left Blank!', "info");	
                                    gotoSlideFlag = acCurrent;

                                }else{
                                    Common.removeErrorParams('#'+odometerId);
                                }
                            }
			var checkboxAll ="questionN_"+selSliderId;
			var checkTickFlag =false;
			$("input."+checkboxAll+"[type='checkbox']").each(function () {				if($(this).is(":checked") && $(this).attr("data-otherval")=='Other'){
					var otherTextId = "otherText_"+selSliderId;

					if($('.'+otherTextId).val()=='' || $('.'+otherTextId).val()=='null' || $('.'+otherTextId).val()==undefined){
						toastr['info']('Other Reason cann\'t left Blank!', "info");
						checkFinishFlag ='0';
					}
				}
			});
			
			if(checkFinishFlag=='1'){
				swal({
				  title: "Are you sure?",
				  text: "You want to finish!",
				  type: "warning",
				  allowOutsideClick: true,
				  showCancelButton: true,
				  confirmButtonColor: "#DD6B55",
				  confirmButtonText: "Yes, Finish it!",
				  cancelButtonText: "No, cancel please!",
				  closeOnConfirm: true,
				  closeOnCancel: true
				},
				function(isConfirm){
				  if (isConfirm)
                                  { 
                                    //alert("I am in bx Slider Finish");
                                    dealerQCDatatable.finishQcPanelAction();
				  } 
                                  else 
                                  {
					
				  }
				});
			}			
		});
		
	},
	
	finishQcPanelAction: function(){
		var formData = $('#qcPanelForm').serialize();
		var certId =	$('#certificationID').val();
		var nameForm = $('#nameform').val();
		$.ajax({
			type: "POST",
			url:'/stockqc/savestockqc',
			data:'name='+nameForm+'&formData='+formData,            
				success: function(objReturn){
//					var objReturn = jQuery.parseJSON(msg);
					if(objReturn.status==true){
						toastr['success']('Data Updated successfully!', "success");
						$(window.opener.document).find('.doqcele'+certId).after( "&nbsp;&nbsp;<label class='label label-success'>Done</label>" );
						$(window.opener.document).find('.doqcele'+certId).remove('.doqcele'+certId);
						//$(window.opener.document).find('.doqcedit'+certId).remove('.doqcedit'+certId);
						var objWindow = window.open(location.href, "_self");
						objWindow.close();
								
					}else{
						toastr['error'](objReturn.reason, "error");
					}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				toastr['error'](errorThrown, "error");
			}
		});
	},
	getModelList: function(){
		// get Model List
		$(document).on("on change","#car_make_22",function(e){
			var make_id = $('#car_make_22').val();
			$.ajax({
				type: "POST",
				url:'ajax',
				data:'getModelList=getModelList&make_id='+make_id,            
					success: function(msg){
						if(msg){
							$('#car_model_22').html('');
							$('#car_model_22').html(msg).trigger('change');
						}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					toastr['error'](errorThrown, "error");
				}
			});			
		});
	},
	
	getVersionList: function(){
		// get Version List.
		$(document).on("change","#car_model_22",function(e){
			var model_id = $('#car_model_22').val();
			$.ajax({
				type: "POST",
				url:'ajax',
				data:'qcVersionList=qcVersionList&model_id='+model_id,            
					success: function(msg){
						if(msg){
							$('#car_version_22').html('');
							$('#car_version_22').html(msg).trigger('change');					
						}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					toastr['error'](errorThrown, "error");
				}
			});			
		});
	},
	
	getFuelTransType: function(){
		// get Fuel Transmission Type.
		$(document).on("change","#car_version_22",function(e){
			var variant_id = $('#car_version_22').val();
			$.ajax({
				type: "POST",
				url:'ajax',
				data:'qcVersionFuelType=qcVersionFuelType&variant_id='+variant_id,            
					success: function(msg){
					
						if(msg){
							var objReturn = jQuery.parseJSON(msg);
							$('#fuel_type_22').val('');
							$('#fuel_type_22').val(objReturn.fuel_type).trigger('change');
							$('#trans_type_22').val('');
							$('#trans_type_22').val(objReturn.trans_type).trigger('change');
							
							$('#cng_lpg_fitment_22').html(objReturn.fitment).trigger('change');
							$('#cng_lpg_fitment_endorsement_rc_22').html(objReturn.endorsement).trigger('change');
							$('#cng_lpg_removal_22').html(objReturn.removal).trigger('change');
							
							//$('#cng_lpg_fitment_22').val('0').trigger('change');
							//$('#cng_lpg_fitment_endorsement_rc_22').val('0').trigger('change');
							//$('#cng_lpg_removal_22').val('0').trigger('change');
						}else{
							$('#fuel_type_22').val('');
							$('#trans_type_22').val('');
							
							$('#cng_lpg_fitment_22').val('0').trigger('change');
							$('#cng_lpg_fitment_endorsement_rc_22').val('0').trigger('change');
							$('#cng_lpg_removal_22').val('0').trigger('change');
						}
				},
				error : function(XMLHttpRequest, textStatus, errorThrown) {
					toastr['error'](errorThrown, "error");
				}
			});			
		});
	},
	
	qcCropImage: function(){
		
		$(document).on("click",".cropControlReset",function(e){
			console.log(cropContainerPreload.options);
			var imageSetUrl = cropContainerPreload.options.loadPicture;
			var uniqueImgId = cropContainerPreload.options.customUploadButtonId;
			if (cropContainerPreload.options.imgEyecandy)
				cropContainerPreload.imgEyecandy.hide();

			cropContainerPreload.destroy();
			
			cropContainerPreload.obj.append('<div class="slider-btn imageEditContainer" id="'+uniqueImgId+'" style="margin-right:10px">Image Edit</div><img class="img-responsive croppedImg" src="' + imageSetUrl + '">');
			if (cropContainerPreload.options.outputUrlId !== '') { $('#' + cropContainerPreload.options.outputUrlId).val(imageSetUrl); }

			cropContainerPreload.croppedImg = cropContainerPreload.obj.find('.croppedImg');

			cropContainerPreload.init();

			cropContainerPreload.hideLoader();
			$( ".cropControlRemoveCroppedImage").hide();
		});
		
		$(document).on("click",".imageEditContainer",function(e){
			var selSliderIdCrop =	$(this).attr('id');
			var croppicContainerId = "cropContainerPreload-"+selSliderIdCrop; 
			var croppicImagePath = $('#'+croppicContainerId+' img').attr('src');
			
			console.log(croppicImagePath);
			var croppicContainerPreloadOptions = {
					modal:true,
					customUploadButtonId:selSliderIdCrop,
					imgEyecandy:true,
					imgEyecandyOpacity:0.4,
					zoomFactor:10,
					doubleZoomControls:false,
					rotateFactor:90,
					rotateControls:false,
					uploadUrl:'ajax',
					cropUrl:'ajax',
					loadPicture:croppicImagePath,
					enableMousescroll:true,
					loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
					onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
					onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
					onImgDrag: function(){ console.log('onImgDrag') },
					onImgZoom: function(){ console.log('onImgZoom') },
					onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
					onAfterImgCrop:function(msg){
					 var finalOutUrl = msg.url;
						if(msg.status=='success'){
							toastr['success']('Image cropped successfully!', "success");
							d = new Date();
							$('#'+croppicContainerId+' img').addClass('img-responsive');
							$('#'+croppicContainerId+' img').attr("src", finalOutUrl+"?"+d.getTime());
						}else{
							toastr['error']('Error in cropping Image!', "error");
						}
						
						$( ".cropControlRemoveCroppedImage").hide();
						console.log('onAfterImgCrop');
					},
					onReset:function(){ 
						console.log('onReset-1');					
					},
					onError:function(errormessage){ console.log('onError:'+errormessage) }
			}
			cropContainerPreload = new Croppic(croppicContainerId, croppicContainerPreloadOptions);
			var imageSetUrl = cropContainerPreload.options.loadPicture;
			var uniqueImgId = cropContainerPreload.options.customUploadButtonId;
			cropContainerPreload.obj.append('<div class="slider-btn imageEditContainer" id="'+uniqueImgId+'" style="margin-right:10px">Image Edit</div><img class="img-responsive croppedImg" src="' + imageSetUrl + '">');
		});
		
		$(document).on("click",".imageEditContainerCropper, .imageEditContainerCropperZoom",function(e){ 
		'use strict';

		 //e.preventDefault();$(".imageEditContainerCropper").remove();
//		alert('I am In');
			var vccID     = $('#certificationID').val();
			$('.docs-buttons').removeClass('hide');
			$('.docs-buttons-optional').addClass('hide');
			var selSliderIdCrop =	$(this).attr('id');
			var croppicContainerId = "imageCont-"+selSliderIdCrop;
			var croppicImagePathUrl = $('#'+croppicContainerId).attr('src');
			var croppicImagePathDir = $('#'+croppicContainerId).attr('img-path');
			var croppicImageId = $('#'+croppicContainerId).attr('img-id');
			var imageElemName = $('#'+croppicContainerId).attr('img-name');
			var imageElemCertId = $('#'+croppicContainerId).attr('cert-id');
			var imageElemType = $('#'+croppicContainerId).attr('img_type');
			
			if($(this).hasClass( "imageEditContainerCropper" )){
				$("button[data-method='setDragMode']").removeClass('hide');
				var options = {
					preview: '.img-preview',
					background: false,
					aspectRatio: 16 / 9,
					autoCropArea:0.9,
					movable:false,
					zoomable:false,
					minCropBoxWidth:300,
					minCropBoxHeight:300,
					viewMode:1,
                                        checkCrossOrigin : false,
				  };
			}else{
				$("button[data-method='setDragMode']").addClass('hide');
				var options = {
					preview: '.img-preview',
					background: false,
					aspectRatio: 16 / 9,				
					autoCropArea:1,
					movable:true,
					zoomable:true,
					dragMode:'move',
					minCropBoxWidth:300,
					minCropBoxHeight:300,
					viewMode:3,
                                        checkCrossOrigin : false,
				  };
			}
			'use strict';
			//alert(croppicContainerId);
			//alert(croppicImagePathUrl);
			//alert(croppicImagePathDir);
			var console = window.console || { log: function () {} };
			var $image = $('#'+croppicContainerId);
			var $download = $('#download');
			

			// Tooltip
			//$('[data-toggle="tooltip"]').tooltip();
			// Cropper
			$image.on({
			'build.cropper': function (e) {
			  console.log(e.type);
			},
			'built.cropper': function (e) {
			  console.log(e.type);
			},
			'cropstart.cropper': function (e) {
			  console.log(e.type, e.action);
			},
			'cropmove.cropper': function (e) {
			  console.log(e.type, e.action);
			},
			'cropend.cropper': function (e) {
			  console.log(e.type, e.action);
			  //alert('I am in Crop End');
			},
			'crop.cropper': function (e) {
				//alert('I am crop.cropper');
			  console.log(e.type, e.x, e.y, e.width, e.height, e.rotate, e.scaleX, e.scaleY);
			},
			'zoom.cropper': function (e) {
			  console.log(e.type, e.ratio);
			}
			}).cropper(options);

			// Methods
			$('.docs-buttons').on('click', '[data-method]', function () {
			var $this = $(this);
			var data = $this.data();
			var $target;
			var result;
			
			e.preventDefault(); 
			if(e.handled === true) {
				return false;
			} else{
				e.handled=true;
			}
			
			if ( typeof $image.data('cropper') == 'undefined'){
				return;
			}
			
			if ($this.prop('disabled') || $this.hasClass('disabled')) {
			  return;
			}

			if ($image.data('cropper') && data.method) {
			
			data = $.extend({}, data); // Clone a new one

			  if (typeof data.target !== 'undefined') {
				$target = $(data.target);

				if (typeof data.option === 'undefined') {
				  try {
					data.option = JSON.parse($target.val());
				  } catch (e) {
					console.log(e.message);
				  }
				}
			  }
			  result = $image.cropper(data.method, data.option, data.secondOption);
			  switch (data.method) {
				case 'scaleX':
				case 'scaleY':
				  $(this).data('option', -data.option);
				  break;

				case 'getCroppedCanvas':
				  if (result) {

					// Bootstrap's Modal
					$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

					if (!$download.hasClass('disabled')) {
					  $download.attr('href', result.toDataURL('image/jpeg'));
					}
				  }

				  break;
				  case 'setDragMode':
					console.log('I am in Crop Section');
					//console.log($image.data('cropper').getData());
					Common.showOverlay();
					var imageCropDataObj = $image.data('cropper').getData();
					var imageCropBoxDataObj = $image.data('cropper').getImageData();
					//console.log(canvas.toDataURL);
					imageCropDataObj=JSON.stringify(imageCropDataObj);
					imageCropBoxDataObj=JSON.stringify(imageCropBoxDataObj);
					var nameForm ='cropperImageCrop';
					$.ajax({
						type: "POST",
						url:'/stockqc/cropimage',
						data:'name='+nameForm+'&imageData='+imageCropDataObj+'&imageCropData='+imageCropBoxDataObj+'&imageurl='+croppicImagePathUrl+'&imagePath='+croppicImagePathDir+'&vccID='+vccID+'&imageId='+croppicImageId+'&imageName='+imageElemName+'&certId='+imageElemCertId+'&imgType='+imageElemType,            
						success: function(objReturn){//alert(msg);
//							var objReturn = jQuery.parseJSON(msg);
							if(objReturn.status==true){
								toastr['success']('Image Cropped successfully!', "success");	
								$('.docs-buttons').addClass('hide');
								$('.docs-buttons-optional').removeClass('hide');
								$image.data('cropper').destroy();
								var d = new Date();
								$('#'+croppicContainerId).addClass('img-responsive');
								//$('#'+croppicContainerId).attr("src", croppicImagePathUrl+"?"+d.getTime());
								$('#'+croppicContainerId).attr("img-name", objReturn.imageName);
								$('#'+croppicContainerId).attr("src", objReturn.url+"?"+d.getTime());
								Common.hideOverlay();
							}else{
								$image.data('cropper').destroy();
								Common.hideOverlay();
								toastr['error'](objReturn.reason, "error");
							}
						},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							$image.data('cropper').destroy();
							Common.hideOverlay();
							toastr['error'](errorThrown, "error");
						}
					});

				  break;
				  
				  case 'clear':
					console.log('I am in Clear Section');
					$('.docs-buttons').addClass('hide');
					$('.docs-buttons-optional').removeClass('hide');
					$image.data('cropper').clear();
					$image.data('cropper').reset();
					$image.data('cropper').destroy();
				  break;
				  
				  case 'getImageData':
					console.log('I am in getImageData');
					//console.log(data);
				  break;

				  
			  }

			  if ($.isPlainObject(result) && $target) {
				try {
				  $target.val(JSON.stringify(result));
				} catch (e) {
				  console.log(e.message);
				}
			  }

			}
			});

			// Keyboard
			$(document.body).on('keydown', function (e) {

			if (!$image.data('cropper') || this.scrollTop > 300) {
			  return;
			}

			switch (e.which) {
			  case 37:
				e.preventDefault();
				$image.cropper('move', -1, 0);
				break;

			  case 38:
				e.preventDefault();
				$image.cropper('move', 0, -1);
				break;

			  case 39:
				e.preventDefault();
				$image.cropper('move', 1, 0);
				break;

			  case 40:
				e.preventDefault();
				$image.cropper('move', 0, 1);
				break;
			}

			});
		});		
	},
	


	qcReportPopup: function(){
		
		$('#historyModal').on('show.bs.modal', function (event) {
			var button      = $(event.relatedTarget);
			var certificationID = button.data('certid');
			var sectionVar  = button.data('section');
			var modal       = $(this);
			var modalHtmlBody   = '';
			var titleText   = '';
			switch(sectionVar) {
				case 'report':
					titleText = 'Report';
					modalHtmlBody = '<iframe width="100%" frameborder="0" height="520px;" src="'+GPATH_BASE_REL+'inspection/view?cert_id='+certificationID+'&output=html&source=inspection&utm_source=inspback&utm_medium=qc&underbody=1"></iframe>';
					break;
				case 'document': 
					titleText = 'Document';
					modalHtmlBody = '<iframe width="100%" frameborder="0" height="520px;" src="'+GPATH_BASE_REL+'inspection/document?cert_id='+certificationID+'&output=html&source=inspection"></iframe>';
					break;
				default:
					//to do
					break;
			} 
				
			modal.find('#myModalLabel').html( titleText );
			modal.find('.modal-body').html( modalHtmlBody );
		});
	},
	
	qcResetFilter: function() {
                GETSTATUS = '1';
		$("#reset_result").click(function() {
                        GETSTATUS = '0';
			$("#reg_no,#date_from,#date_to").val('');
			$("#ce_name").select2("val", "0");
			$("#dealer_name").select2("val", "0");
			$("#city_name").select2("val", "0");
			//$("#ce_status").select2("val", "0");
			$("#owner_in_prg").select2("val", "0");
			$("#invt_status").select2("val", "2");
			$("#na_status").select2("val", "");
			$("#inspection_status").select2("val", "");
                        $("#docu_sign").select2("val", "");
			dealerQCDatatable.dataTable();
                        GETSTATUS = 1;
		});
	},
	
	qcResetFilterAll: function() {
                GETSTATUS = 0;
		$("#reg_no,#date_from,#date_to").val('');
		$("#ce_name").select2("val", "0");
		$("#dealer_name").select2("val", "0");
		$("#city_name").select2("val", "0");
		//$("#ce_status").select2("val", "0");
		$("#owner_in_prg").select2("val", "0");
		$("#invt_status").select2("val", "2");
		$("#na_status").select2("val", "");
		$("#inspection_status").select2("val", "");
                $("#docu_sign").select2("val", "");
                GETSTATUS = 1;
	},
        
       docuSignResetFilter: function() {
            GETSTATUS = '1';
            $("#docusign_reset_result").click(function() {
                    GETSTATUS = '0';
                    $("#reg_no,#date_from,#date_to").val('');
                    $("#ce_name").select2("val", "0");
                    $("#dealer_name").select2("val", "0");
                    $("#city_name").select2("val", "0");
                    //$("#ce_status").select2("val", "0");
                    //$("#owner_in_prg").select2("val", "0");
                    $("#invt_status").select2("val", "2");
                    $("#na_status").select2("val", "");
                    $("#inspection_status").select2("val", "");
                    $("#rc_status").select2("val", "");
                    $("#qc_status").select2("val", "");
                    dealerQCDatatable.docuSigndataTable();
                    GETSTATUS = 1;
            });
	},
        
       docuSignResetFilterAll: function() {
                GETSTATUS = 0;
		$("#reg_no,#date_from,#date_to").val('');
		$("#ce_name").select2("val", "0");
		$("#dealer_name").select2("val", "0");
		$("#city_name").select2("val", "0");
		//$("#owner_in_prg").select2("val", "0");
		$("#invt_status").select2("val", "2");
		$("#na_status").select2("val", "");
		$("#inspection_status").select2("val", "");
                $("#rc_status").select2("val", "");
                $("#qc_status").select2("val", "");
                GETSTATUS = 1;
	},
	
	qcListFilter: function() {
                $('.searchFilter').on('keypress',function(e) {
                    if(GETSTATUS == 1 && e.which == 13 ){
                        $("#search_result").click();
                    }
                });
                $('.changeFilter').on('change',function(e) {
                    if(GETSTATUS == 1 && e.type == 'change'){
                       $("#search_result").click();
                    }
                });
                
		$("#search_result").click(function() {
			if($("#reg_no").val()=='' && $("#date_from").val()==''  && $("#date_to").val()==''
			 && $("#dealer_name").select2("val")=='0'
			&& $("#city_name").select2("val")=='0' && $("#ce_name").select2("val")=='0'  && $("#owner_in_prg").select2("val")=='0' && $("#invt_status").select2("val")=='0' && $("#na_status").select2("val")=='' && $("#inspection_status").select2("val", "")){
				toastr['info']('Select at least one value to filter list!', "info");
			}else{
				dealerQCDatatable.dataTable();
			}
		});
		
		$(".pendingList").click(function() {
			$("#listFlag").val("1");
                        $(".docu_sign").hide();
			dealerQCDatatable.qcResetFilterAll();
			dealerQCDatatable.dataTable();
		});
		
		$(".approvedList").click(function() {
			$("#listFlag").val("2");
                        $(".docu_sign").show();
			dealerQCDatatable.qcResetFilterAll();
			dealerQCDatatable.dataTable();
		});
		
		$(".sentForCorrectionList").click(function() {
			$("#listFlag").val("3");
                        $(".docu_sign").hide();
			dealerQCDatatable.qcResetFilterAll();
			dealerQCDatatable.dataTable();
		});
		
		$(".reQcRequiredList").click(function() {
			$("#listFlag").val("5");
                        $(".docu_sign").hide();
			dealerQCDatatable.qcResetFilterAll();
			dealerQCDatatable.dataTable();
		});
		
		$(".rejectedList").click(function() {
			$("#listFlag").val("4");
                        $(".docu_sign").show();
			dealerQCDatatable.qcResetFilterAll();
			dealerQCDatatable.dataTable();
		});
	},
        docuSignListFilter: function() {
                $('.searchFilter').on('keypress',function(e) {
                    if(GETSTATUS == 1 && e.which == 13 ){
                        $("#docusign_search_result").click();
                    }
                });
                $('.changeFilter').on('change',function(e) {
                    if(GETSTATUS == 1 && e.type == 'change'){
                       $("#docusign_search_result").click();
                    }
                });
                
		$("#docusign_search_result").click(function() {
			if($("#reg_no").val()=='' && $("#date_from").val()==''  && $("#date_to").val()==''
			 && $("#dealer_name").select2("val")=='0'
			&& $("#city_name").select2("val")=='0' && $("#ce_name").select2("val")=='0'  && $("#owner_in_prg").select2("val")=='0' && $("#invt_status").select2("val")=='0' && $("#na_status").select2("val")=='' && $("#inspection_status").select2("val", "")){
				toastr['info']('Select at least one value to filter list!', "info");
			}else{
				dealerQCDatatable.docuSigndataTable();
			}
		});
		
 
        // Docu Sign Tab Filter.

            $(".docuSignPendingList").click(function() {
                $("#listFlag").val("1");
                $(".docu_sign").hide();
                dealerQCDatatable.docuSignResetFilterAll();
                dealerQCDatatable.docuSigndataTable();
            });

            $(".docuSignReuploadList").click(function() {
                $("#listFlag").val("2");
                $(".docu_sign").hide();
                dealerQCDatatable.docuSignResetFilterAll();
                dealerQCDatatable.docuSigndataTable();
            });

            $(".docuSignCompletedList").click(function() {
                $("#listFlag").val("3");
                $(".docu_sign").hide();
                dealerQCDatatable.docuSignResetFilterAll();
                dealerQCDatatable.docuSigndataTable();
            });
	},
	qcPanelSlider: function() {
		gotoSlideFlag = '';
		sliderNextCount = '0';
		 slider =   $('.bxslider').bxSlider({
			nextSelector: '#slider-next',
			prevSelector: '#slider-prev',
			nextText: 'Next',
			prevText: 'Previous',
			startSlide: 0,
			infiniteLoop : false,
			pager : false,
			auto :false,
			onSliderLoad: function(currentIndex) {		  	
				console.log('in slider load');
				current = currentIndex+1;
				var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
				var titleDivId	=	'tag-name-'+selSliderId;
				//Set title tag name
				var titleName = $("#"+titleDivId ).val();
				$( ".tag-name-title").html('');
				$( ".tag-name-title").html(titleName);
				console.log(current);

				var selSliderIdCrop =	$(".bxslider li:nth-child("+current+")").attr('id');
				var croppicContainerId = "cropContainerPreload-"+selSliderIdCrop; 
				var croppicImagePath = $('#'+croppicContainerId+' img').attr('src');
				console.log(croppicImagePath);
				var croppicContainerPreloadOptions = {
						modal:true,
						imgEyecandyOpacity:0.4,
						processInline:false,
						zoomFactor:10,
						doubleZoomControls:false,
						rotateFactor:90,
						rotateControls:true,	
						uploadUrl:'ajax',
						cropUrl:'ajax',
						loadPicture:croppicImagePath,
						enableMousescroll:true,
						loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
						onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
						onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
						onImgDrag: function(){ console.log('onImgDrag') },
						onImgZoom: function(){ console.log('onImgZoom') },
						onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
						onAfterImgCrop:function(msg){
						
							if(msg.status=='success'){
								toastr['success']('Image cropped successfully!', "success");
							}else{
								toastr['error']('Error in cropping Image!', "error");
							}
							
							$( ".cropControlRemoveCroppedImage").hide();
							console.log('onAfterImgCrop');
							
						},
						onReset:function(){ console.log('onReset') },
						onError:function(errormessage){ console.log('onError:'+errormessage) }
				}
				//var cropContainerPreload = new Croppic(croppicContainerId, croppicContainerPreloadOptions);
			},
			onSlidePrev: function() {
				var current = slider.getCurrentSlide();
			},
			onSlideAfter: function(){

			var nextslideFlag = $('#nextprevflag').val();
			if(nextslideFlag!='1'){ // Skip these steps in case of previous slide.
				if(sliderNextCount=='1'){
					sliderNextCount ='0'
					return false;
				}

				if(gotoSlideFlag>0){
					gotoSlideFlag = gotoSlideFlag-1;
				}

				// In case of validation failed then pause to current slide.
					if(gotoSlideFlag!='' && gotoSlideFlag!='null' && gotoSlideFlag!=undefined){
						sliderNextCount = '1';
						slider.goToPrevSlide();
						return false;
					}else if(gotoSlideFlag=='0'){
						sliderNextCount = '1';
						slider.goToPrevSlide();
						return false;
					}else{
						gotoSlideFlag ='';
					}
				}
				// do mind-blowing JS stuff here
				console.log('In Slide After'+gotoSlideFlag);
				var current = slider.getCurrentSlide();
				var acCurrent = current;
				current = current+1;
				var total = slider.getSlideCount();
				console.log(current+'-'+acCurrent+'--'+total);
				console.log($(".bxslider li:nth-child("+current+")").attr('id'));
				if(current==total || acCurrent==0){
					console.log('finished');
					var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
					var imageDivId	=	'image-tag-'+selSliderId;
					var fieldDivId	=	'field-tag-'+selSliderId;
                                        if(selSliderId == '15')
                                        {
                                            fieldDivId	=	'field-tag-14';
                                        }
					var titleDivId	=	'tag-name-'+selSliderId;
					console.log(imageDivId);
					
					// Show hide corresponding tag image-tag-pane
					$( ".image-tag-pane").hide();
					$( "#"+imageDivId ).show();
					
					// Show hide corresponding tag field-tag-pane
					$(".field-tag-pane").hide();
					$("."+fieldDivId).show();
					
					//Set title tag name
					var titleName = $("#"+titleDivId ).val();
					$( ".tag-name-title").html('');
					$( ".tag-name-title").html(titleName);
					if(current==total){
						$( ".bx-slider-controls .slide-next").hide();
						$( ".bx-slider-controls .slide-prev").show();
						$( ".bx-slider-controls .slide-finish").show();
					}else if(acCurrent==0){
						$( ".bx-slider-controls .slide-next").show();
						$( ".bx-slider-controls .slide-prev").hide();
						$( ".bx-slider-controls .slide-finish").hide();
						
					}
					
				}else{
					$( ".bx-slider-controls .slide-finish").hide();
					$( ".bx-slider-controls .slide-next").show();
					$( ".bx-slider-controls .slide-prev").show();
					var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
					var imageDivId	=	'image-tag-'+selSliderId;
					var fieldDivId	=	'field-tag-'+selSliderId;
                                        if(selSliderId == '15')
                                        {
                                            fieldDivId	=	'field-tag-14';
                                        }
					var titleDivId	=	'tag-name-'+selSliderId;
					console.log(imageDivId);
					
					// Show hide corresponding tag image-tag-pane
					$( ".image-tag-pane").hide();
					$( "#"+imageDivId ).show();
					
					// Show hide corresponding tag field-tag-pane
					$(".field-tag-pane").hide();
					$("."+fieldDivId).show();

					//Set title tag name
					var titleName = $("#"+titleDivId ).val();
					$( ".tag-name-title").html('');
					$( ".tag-name-title").html(titleName);
				}
				var selSliderIdCrop =	$(".bxslider li:nth-child("+current+")").attr('id');
				var croppicContainerId = "cropContainerPreload-"+selSliderIdCrop; 
				var croppicImagePath = $('#'+croppicContainerId+' img').attr('src');
				var carouselContainerId = "carousel"+selSliderIdCrop;
				//var selCarouSliderIdCrop =	$("#"+carouselContainerId+" div.carousel-inner div.item").hasClass("active").attr("id");
				//alert(selCarouSliderIdCrop);
				console.log(croppicImagePath);
				
				var croppicContainerPreloadOptions = {
						modal:true,
						imgEyecandyOpacity:0.4,
						processInline:false,
						zoomFactor:10,
						doubleZoomControls:false,
						rotateFactor:90,
						rotateControls:true,
						uploadUrl:'ajax',
						cropUrl:'ajax',
						loadPicture:croppicImagePath,
						enableMousescroll:true,
						loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
						onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
						onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
						onImgDrag: function(){ console.log('onImgDrag') },
						onImgZoom: function(){ console.log('onImgZoom') },
						onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
						onAfterImgCrop:function(msg){
						
							if(msg.status=='success'){
								toastr['success']('Image cropped successfully!', "success");
							}else{
								toastr['error']('Error in cropping Image!', "error");
							}
							
							$( ".cropControlRemoveCroppedImage").hide();
							console.log('onAfterImgCrop');
						},
						onReset:function(){ console.log('onReset') },
						onError:function(errormessage){ console.log('onError:'+errormessage) }
				}
				//var cropContainerPreload = new Croppic(croppicContainerId, croppicContainerPreloadOptions);
				
				$('#'+carouselContainerId).carousel({
					pause: true,
					interval: false 
				});
				
				/*$('#'+carouselContainerId).on('slid.bs.carousel', function () {
					alert($("#"+carouselContainerId+" div.carousel-inner div.item.active").attr("id"));
				});*/

			},
			onSlideNext: function($slideElement, oldIndex, newIndex){
				// This is to reset previous initialize crop image.
				$("button[data-method='clear']").trigger("click");
				console.log('In Slide Next'+gotoSlideFlag);
				gotoSlideFlag = '';
				var current = slider.getCurrentSlide();
				var total = slider.getSlideCount();
				var acCurrent = current;
				current = current;

				var selSliderId =	$(".bxslider li:nth-child("+current+")").attr('id');
				var checkboxAll ="questionN_"+selSliderId;
				var checkTickFlag =false;

				$("input."+checkboxAll+"[type='checkbox']").each(function () {
					var tempId = $(this).attr("id");
					
					if($(this).is(":checked") && $(this).attr("data-otherval")=='Other'){
						var otherTextId = "otherText_"+selSliderId;

						if($('.'+otherTextId).val()=='' || $('.'+otherTextId).val()=='null' || $('.'+otherTextId).val()==undefined){
							toastr['info']('Other Reason cann\'t left Blank!', "info");
							gotoSlideFlag = acCurrent;
						}
					}
				});
				if(selSliderId=='1'){//Odometer Reading
					var regnoId = "field_regno";
					
					if($('#'+regnoId).val()=='' || $('#'+regnoId).val()=='null' || $('#'+regnoId).val()==undefined){
						Common.addErrorParams('#'+regnoId);
						toastr['info']('Reg No cann\'t left Blank!', "info");	
						gotoSlideFlag = acCurrent;
							
					}else{
						Common.removeErrorParams('#'+regnoId);
					}
				}
				if(selSliderId=='12'){//Odometer Reading
					var odometerId = "field_km";
					
					if($('#'+odometerId).val()=='' || $('#'+odometerId).val()=='null' || $('#'+odometerId).val()==undefined){
						Common.addErrorParams('#'+odometerId);
						toastr['info']('Odometer reading cann\'t left Blank!', "info");	
						gotoSlideFlag = acCurrent;
							
					}else{
						Common.removeErrorParams('#'+odometerId);
					}
				}
			},
			onSlideBefore: function(currIndex){
				console.log('In Slide before');
			}				
		});	
	},	
	dataTable: function() {
		var name = "DealerQcList";

		var list_flag       = $("#listFlag").val();
		var ce_name         = $("#ce_name").val();
		var dealer_name     = $("#dealer_name").val();
		var city_name       = $("#city_name").val();
		var reg_no          = $("#reg_no").val();
		var ce_status       = '';//$("#ce_status").val();
		var date_from       = $("#date_from").val();
		var date_to         = $("#date_to").val();
		var owner_in_prg    = $("#owner_in_prg").val();
		var invt_status     = $("#invt_status").val();
		var na_status     	= $("#na_status").val();
		var inspection_status= $("#inspection_status").val();
                var docu_sign       = $("#docu_sign").val();
		//alert(list_flag+'out');
/*	if(list_flag=='3'){ alert(list_flag+'1');
			$("#dealerQCTable").DataTable({
							"aoColumns":  [
								{ "sTitle": "Dealer Name" ,"width": "22%"},
								{ "sTitle": "CE Name" ,"width": "15%"},
								{ "sTitle": "City" ,"width": "10%"}, 
								{ "sTitle": "Reg No" ,"width": "10%"},
								{ "sTitle": "Reg No1" ,"width": "10%"},
											{ "sTitle": "Request Date" ,"width": "13%"},
											{ "sTitle": "CE Status" ,"width": "15%"},
											{ "sTitle": "Report", "bSortable": false,"width": "6%"},
								{ "sTitle": "Action", "bSortable": false,"width": "6%"}
							],
				"bFilter": true,
				"bProcessing": true,
				"bServerSide": true,
				"destroy": true,
				"sAjaxSource": "ajax",
							"fnPreDrawCallback": function() {
								// gather info to compose a message
								Common.showOverlay();
								return true;
							},
							"fnDrawCallback": function() {
								// in case your overlay needs to be put away automatically you can put it here
								Common.hideOverlay();
							},
				"fnServerParams": function(aoData) {
								aoData.push({"name": "name",  "value": name});
								aoData.push({"name": "list_flag",  "value": list_flag});
								aoData.push({"name": "ce_name", "value": ce_name});
								aoData.push({"name": "owner_in_prg", "value": owner_in_prg});
								aoData.push({"name": "dealer_name","value": dealer_name});
								aoData.push({"name": "city_name",  "value": city_name});					
								aoData.push({"name": "reg_no","value": reg_no});
								aoData.push({"name": "ce_status","value": ce_status});
								aoData.push({"name": "invt_status","value": invt_status});					
								aoData.push({"name": "date_from","value": date_from});
								aoData.push({"name": "date_to","value": date_to});
				}
			});
		}else{*/
		oTable =	$("#dealerQCTable").DataTable({
					"aoColumns":  [
						{ "sTitle": "Dealer Name" ,"width": "22%"},
						{ "sTitle": "CE Name" ,"width": "15%"},
						{ "sTitle": "City" ,"width": "8%"}, 
						{ "sTitle": "Reg No" ,"width": "8%"},
						{ "sTitle": "#Unsat Count <BR> M/NM" ,"width": "5%"},
                                                { "sTitle": "Request Date" ,"width": "11%"},
                                                { "sTitle": "Inspection Status" ,"width": "10%"},
                                                { "sTitle": "Finance Price" ,"width": "8%"},
                                                { "sTitle": "Report", "bSortable": false,"width": "4%"},
                                                { "sTitle": "Docu<br>signed", "bSortable": false,"width": "2%"},
						{ "sTitle": "Action", "bSortable": false,"width": "9%"}
					],
			"bFilter": true,
			"bProcessing": true,
			"bServerSide": true,
			"destroy": true,
			"sAjaxSource": "ajax",
					"fnPreDrawCallback": function() {
						// gather info to compose a message
						Common.showOverlay();
						return true;
					},
					"fnDrawCallback": function() {
						// in case your overlay needs to be put away automatically you can put it here
						Common.hideOverlay();
					},
			"fnServerParams": function(aoData) {
						aoData.push({"name": "name",  "value": name});
						aoData.push({"name": "list_flag",  "value": list_flag});
						aoData.push({"name": "ce_name", "value": ce_name});
						aoData.push({"name": "owner_in_prg", "value": owner_in_prg});
						aoData.push({"name": "dealer_name","value": dealer_name});
						aoData.push({"name": "city_name",  "value": city_name});					
						aoData.push({"name": "reg_no","value": reg_no});
						aoData.push({"name": "ce_status","value": ce_status});
						aoData.push({"name": "invt_status","value": invt_status});
						aoData.push({"name": "na_status","value": na_status});
						aoData.push({"name": "inspection_status","value": inspection_status});						
						aoData.push({"name": "date_from","value": date_from});
						aoData.push({"name": "date_to","value": date_to});
                                                aoData.push({"name": "docu_sign","value": docu_sign});
			}
			});
			//oTable = $('#dealerQCTable').dataTable(); 
			if(list_flag!='3'){ //alert(list_flag);
				oTable.column( '4' ).visible( false );
				//oTable.columns.adjust().draw();
			}
                        if(list_flag!='2' && list_flag!='4'){ //alert(list_flag);
                                oTable.column( '7' ).visible( false );
				oTable.column( '9' ).visible( false );
				//oTable.columns.adjust().draw();
			}
		//}
    },	
    docuSigndataTable: function() {
		var name = "DocuSignList";

		var list_flag       = $("#listFlag").val();
		var ce_name         = $("#ce_name").val();
		var dealer_name     = $("#dealer_name").val();
		var city_name       = $("#city_name").val();
		var reg_no          = $("#reg_no").val();
		var ce_status       = '';//$("#ce_status").val();
		var date_from       = $("#date_from").val();
		var date_to         = $("#date_to").val();
		//var owner_in_prg    = $("#owner_in_prg").val();
		var invt_status     = $("#invt_status").val();
		var na_status     	= $("#na_status").val();
		var inspection_status= $("#inspection_status").val();
                var rc_status        = $("#rc_status").val();
                var qc_status        = $("#qc_status").val();

		oTable =$("#docuSignTable").DataTable({
                                "aoColumns":  [
                                        { "sTitle": "Dealer Name" ,"width": "20%"},
                                        { "sTitle": "CE Name" ,"width": "15%"},
                                        { "sTitle": "City" ,"width": "8%"}, 
                                        { "sTitle": "Reg No" ,"width": "8%"},                                        
                                        { "sTitle": "Request Date" ,"width": "12%"},
                                        { "sTitle": "Inspection Status" ,"width": "5%"},
                                        { "sTitle": "QC Status" ,"width": "5%"},
                                        { "sTitle": "RC" ,"width": "2%"},
                                        { "sTitle": "Finance Price" ,"width": "6%"},
                                        { "sTitle": "Report", "bSortable": false,"width": "4%"},
                                        { "sTitle": "Docu<br>signed", "bSortable": false,"width": "2%"},
                                        { "sTitle": "Action", "bSortable": false,"width": "15%"}
                                ],
			"bFilter": true,
			"bProcessing": true,
			"bServerSide": true,
			"destroy": true,
			"sAjaxSource": "ajax",
                        "fnPreDrawCallback": function() {
                                // gather info to compose a message
                                Common.showOverlay();
                                return true;
                        },
                        "fnDrawCallback": function() {
                                // in case your overlay needs to be put away automatically you can put it here
                                Common.hideOverlay();
                        },
			"fnServerParams": function(aoData) {
                            aoData.push({"name": "name",  "value": name});
                            aoData.push({"name": "list_flag",  "value": list_flag});
                            aoData.push({"name": "ce_name", "value": ce_name});                            
                            aoData.push({"name": "dealer_name","value": dealer_name});
                            aoData.push({"name": "city_name",  "value": city_name});					
                            aoData.push({"name": "reg_no","value": reg_no});
                            aoData.push({"name": "ce_status","value": ce_status});
                            aoData.push({"name": "invt_status","value": invt_status});
                            aoData.push({"name": "na_status","value": na_status});
                            aoData.push({"name": "inspection_status","value": inspection_status});						
                            aoData.push({"name": "date_from","value": date_from});
                            aoData.push({"name": "date_to","value": date_to});
                            aoData.push({"name": "rc_status","value": rc_status});
                            aoData.push({"name": "qc_status","value": qc_status});
			}
			});
    }
};


reQCData = {
    initiate: function(){
        $(document).ready(function(){
            Common.toastr();
            var totalTags  = $('#tagCount').val();
            var vccID = $('#vcc').val();
            var counter    =  1;
			var orgCounter = counter;
			var checkValidationFlag = 1;//alert('#taginput_'+counter);
			
            if(totalTags == counter){
                $('#next').hide();
                $('#finishreqc').show();
                /*$('#finishreqc').click(function(){
                    $('#tag_'+currentTag).css("color", "green");
                    swal({
                      title: "Are you sure?",
                      text: "You want to start QC-1-initial!",
                      type: "warning",
                      allowOutsideClick: true,
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Yes, Start it!",
                      cancelButtonText: "No, cancel please!",
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                          if (isConfirm) {
                              var vccID = $('#vcc').val();
                              window.location.href = GPATH_BASE_REL+'qc/reqcpanel?vcc='+vccID;
                          }
                      });  
                  });*/
            }
			
            //alert(currentTag);
			var currentTag =  $('#taginput_'+counter).attr('label');//alert(currentTag);
            //$('#tag_'+currentTag).css("color", "blue");
			$('#tag_'+currentTag).removeClass("re-qc-list-default");
			$('#tag_'+currentTag).addClass("re-qc-list-active");
            $('#'+currentTag).show();
            
            
            $('body').on('click','div.deleteQCImg',function(){
                var intialTagId = $('#currentTagID').val();
                var currentTag =  $('#taginput_'+intialTagId).attr('label');
                var dclsName    = $(this).attr('data-imgname');
                var dclsDS      = $(this).attr('data-delete-status');
                var image_path  = $(this).attr('data-imagefullpath');
                var image_name  = $(this).attr('data-imagefullname');
                var params      = "name=reQCdelete&vcc_id=" +vccID+"&tag_id="+currentTag+"&image_name="+image_name+"&image_path="+image_path;
                var url = "ajax";
                $.post(url, params, function (jsondata) {
                    var resultData  = $.parseJSON(jsondata);
                    if( resultData.status == 'T' ){
                        $('#dropZoneImgDiv').find('.'+dclsName).remove();
                    }
					// Image Upload Tick Against Tag Id.
					var imageUploadCheckId ="image_upload_check_"+currentTag;
					reQCData.reqcImageUploadCheck(imageUploadCheckId,resultData.imageUploadedFlag);
                });
            });
            
            $('body').on('click','div.fa-trash',function(){
                var delClsbox =  $(this).attr('rel');
                $('.'+delClsbox).show();
            });
            
            $('body').on('click','div.nodeleteclr',function(){
                var delClsbox =  $(this).attr('rel');
                $('.'+delClsbox).hide();
             });

				reQCData.getReQCImgDataByAjax(currentTag);
				reQCData.saveReQCData(counter,checkValidationFlag);			 

        });
    },
    reqcImageUploadCheck : function(imageUploadCheckId,checkFlag){
		if(checkFlag == '1'){
			$('#'+imageUploadCheckId).removeClass("reqcimageUploadUnCheck");
			$('#'+imageUploadCheckId).addClass("reqcimageUploadCheck");
		}else{
			$('#'+imageUploadCheckId).addClass("reqcimageUploadUnCheck");
			$('#'+imageUploadCheckId).removeClass("reqcimageUploadCheck");
		}
	},
    saveReQCData : function(counter,checkValidationFlag){
        $('#next').click(function(){
			//alert("In Next Section");
			Common.showOverlay();
			orgCounter	   = Number(counter); //alert(counter);
            counter        =  Number(counter) + 1 ;//alert(counter);
			var vccID = $('#vcc').val();
			var currentTagVal =  $('#taginput_'+orgCounter).attr('label');
			var tempCheckFlag = jQuery.inArray( currentTagVal, pausecontent );
			//alert('currentTag-'+currentTagVal);
			//alert('checkFlag-'+tempCheckFlag);

			/*********Validating Before Moving Next *****/
			var weblayout = $('#qcPanelData').val();
			if(weblayout == 'reQcPanelData'){
				if(tempCheckFlag!=-1){
					var url    = "ajax";
					var name   = "reQcCheck";
					var params = "name="+name+"&vccID="+vccID+"&tagId="+currentTagVal;
					$.post(url,params,function(msg){
						var objReturn = jQuery.parseJSON(msg);//alert(objReturn.status);
						if(objReturn.status==true){
							checkValidationFlag='1';
							if(objReturn.msg!='NA'){
								toastr['success'](objReturn.msg, "success");
							}
							reQCData.actionNextReQCData(vccID,counter,currentTagVal,orgCounter,checkValidationFlag);
	/**********Start**********
				alert(checkValidationFlag);
				$('#previous').show();
				$('#dropZoneImgDiv').empty();
				var totalTags  = $('#tagCount').val();
				var currentTag =  $('#tag_'+counter).attr('label');
				$('#currentTagID').val(counter);
				$('#tag_'+currentTag).css("color", "blue");
				$('#'+currentTag).show();
				if(totalTags == counter){
					$('#next').hide();
					$('#finish').show();
					$('#finish').click(function(){
						$('#tag_'+currentTag).css("color", "green");
						var weblayout = $('#qcPanelData').val();
						if(weblayout == 'reQcPanelData'){
							var url    = "ajax";
							var name   = "reQcCheck";
							var params = "name="+name+"&vccID="+vccID;
							$.post(url,params,function(msg){
								var objReturn = jQuery.parseJSON(msg);
								if(objReturn.status==true){
									toastr['success'](objReturn.msg, "success");
									swal({
									  title: "Are you sure?",
									  text: "You want to start QC-2!",
									  type: "warning",
									  allowOutsideClick: true,
									  showCancelButton: true,
									  confirmButtonColor: "#DD6B55",
									  confirmButtonText: "Yes, Start it!",
									  cancelButtonText: "No, cancel please!",
									  closeOnConfirm: true,
									  closeOnCancel: true
									},
									function(isConfirm){
										  if (isConfirm) {
											  window.location.href = GPATH_BASE_REL+'qc/reqcpanel?vcc='+vccID; 
										  }
									  });								
								}else{
									toastr['error'](objReturn.msg, "error");
								}
							});
						}
	  
					  });
				  }
				  var tagCounter = counter - 1;
				  for(i = 1; i <=tagCounter; i++){
					var value =  $('#tag_'+i).attr('label');
					$('#tag_'+value).css("color", "green");
					$('#'+value).hide();
				  }
				  reQCData.getReQCImgDataByAjax(currentTag);
	/**********END*************/


							
						}else{
							counter = Number(counter)-1;
							checkValidationFlag='0';
							toastr['error'](objReturn.msg, "error");
							Common.hideOverlay();
							return false;
						}
					});
				}else{
					reQCData.actionNextReQCData(vccID,counter,currentTagVal,orgCounter,checkValidationFlag);
				}
			}
			/********************************************/
			
        });
        $('#previous').click(function(){
			Common.showOverlay();
            $('#finishreqc').hide();
            $('#next').show();
            $('#dropZoneImgDiv').empty(); //alert(counter);
            var value =  $('#taginput_'+counter).attr('label');  
            $('#'+value).hide(); 
            $('#tag_'+value).css("color","");
            counter = Number(counter) - 1;
            if(counter == 1){
              $('#previous').hide();
            }
            $('#currentTagID').val(counter);
            var currentTag =  $('#taginput_'+counter).attr('label');
			var currentTagOld =  $('#taginput_'+(Number(counter)+1)).attr('label');
            $('#'+currentTag).show(); 
           // $('#tag_'+currentTag).css("color", "blue");
			$('#tag_'+currentTag).removeClass("re-qc-list-default");
			$('#tag_'+currentTag).removeClass("re-qc-list-visited");
			$('#tag_'+currentTag).addClass("re-qc-list-active");
			
			$('#tag_'+currentTagOld).removeClass("re-qc-list-active");
			$('#tag_'+currentTagOld).removeClass("re-qc-list-visited");
			$('#tag_'+currentTagOld).addClass("re-qc-list-default");
			
			
            reQCData.getReQCImgDataByAjax(currentTag);
			 
        });
		
		$('#finishreqc').click(function(){ //alert(allApplicableMandtTags);alert(allApplicableNonMandtTags);
			Common.showOverlay();
			orgCounter	   = Number(counter);
            //counter        =  counter + 1 ;
			var totalTags  = $('#tagCount').val();
			var currentTag =  $('#taginput_'+orgCounter).attr('label');
			$('#currentTagID').val(orgCounter);
			
			var vccID = $('#vcc').val();
			var currentTagVal =  $('#taginput_'+orgCounter).attr('label');
			var tempCheckFlag = jQuery.inArray( currentTagVal, pausecontent );
			//alert('currentTag-'+currentTag);
			//alert('currentTagVal-'+currentTagVal);
			//alert('checkFlag-'+tempCheckFlag);
			//alert('I am on finish click');
			
			var currentTagVal =  $('#taginput_'+orgCounter).attr('label');
			var weblayout = $('#qcPanelData').val();
			if(weblayout == 'reQcPanelData'){
				if(tempCheckFlag!=-1){
					var url    = "ajax";
					var name   = "reQcCheck";
					var params = "name="+name+"&vccID="+vccID+"&tagId="+currentTagVal;
					$.post(url,params,function(msg){
						var objReturn = jQuery.parseJSON(msg);
						if(objReturn.status==true){
							//Common.hideOverlay();
							//$('#tag_'+currentTag).css("color", "green");
							$('#tag_'+currentTag).removeClass("re-qc-list-active");
							$('#tag_'+currentTag).addClass("re-qc-list-visited");
							if(objReturn.msg!='NA'){
								toastr['success'](objReturn.msg, "success");
							}
								var url    = "ajax";
								var name   = "reQcCheck";
								var params = "name="+name+"&vccID="+vccID+"&tagId=all"+"&finichFlag=1&mandtTags="+allApplicableMandtTags+"&nonMandtTags="+allApplicableNonMandtTags;
								$.post(url,params,function(msg){
									var objReturn = jQuery.parseJSON(msg);
									if(objReturn.status==true){
										Common.hideOverlay();
										//$('#tag_'+currentTag).css("color", "green");
										$('#tag_'+currentTag).removeClass("re-qc-list-active");
										$('#tag_'+currentTag).addClass("re-qc-list-visited");
										if(objReturn.msg!='NA'){
											toastr['success'](objReturn.msg, "success");
										}
										swal({
										  title: "Are you sure?",
										  text: "You want to Finish Image Upload!",
										  type: "warning",
										  allowOutsideClick: true,
										  showCancelButton: true,
										  confirmButtonColor: "#DD6B55",
										  confirmButtonText: "Yes, Finish it!",
										  cancelButtonText: "No, cancel please!",
										  closeOnConfirm: true,
										  closeOnCancel: true
										},
										function(isConfirm){
											  if (isConfirm) {
												  //window.location.href = GPATH_BASE_REL+'qc/reqcpanel?vcc='+vccID; 
												 reQCData.updateReQcImageUploadStatus();
											  }
										  });
									}else{
										Common.hideOverlay();
										toastr['error'](objReturn.msg, "error");
									}
								});
						}else{
							Common.hideOverlay();
							toastr['error'](objReturn.msg, "error");
						}
					});
				}else{
					//$('#tag_'+currentTag).css("color", "green");
					$('#tag_'+currentTag).removeClass("re-qc-list-active");
					$('#tag_'+currentTag).addClass("re-qc-list-visited");
						var url    = "ajax";
						var name   = "reQcCheck";
						var params = "name="+name+"&vccID="+vccID+"&tagId=all"+"&finichFlag=1&mandtTags="+allApplicableMandtTags+"&nonMandtTags="+allApplicableNonMandtTags;
						$.post(url,params,function(msg){
							var objReturn = jQuery.parseJSON(msg);
							if(objReturn.status==true){
								Common.hideOverlay();
								//$('#tag_'+currentTag).css("color", "green");
								$('#tag_'+currentTag).removeClass("re-qc-list-active");
								$('#tag_'+currentTag).addClass("re-qc-list-visited");
								if(objReturn.msg!='NA'){
								toastr['success'](objReturn.msg, "success");
								}
								swal({
								  title: "Are you sure?",
								  text: "You want to Finish Image Upload!",
								  type: "warning",
								  allowOutsideClick: true,
								  showCancelButton: true,
								  confirmButtonColor: "#DD6B55",
								  confirmButtonText: "Yes, Finish it!",
								  cancelButtonText: "No, cancel please!",
								  closeOnConfirm: true,
								  closeOnCancel: true
								},
								function(isConfirm){
									  if (isConfirm) {
										  //window.location.href = GPATH_BASE_REL+'qc/reqcpanel?vcc='+vccID;
										reQCData.updateReQcImageUploadStatus();
									  
									  }
								  });
							}else{
								Common.hideOverlay();
								toastr['error'](objReturn.msg, "error");
							}
						});				
				}
			}
		});
		
		$('.reqc_imageupload_taglist').click(function(){
			//alert('Hi I am Here');
			var vccID = $('#vcc').val();//alert(vccID);
			var currentTagVal =  $(this).attr('label');//alert("CurrentTag:-"+currentTagVal);
			var listCounter =  $(this).attr('list_counter');//alert("new"+listCounter);
			counter =Number(listCounter);
			var currentTagValOld = $('#currentTagID').val();//alert("old"+currentTagValOld);
			var totalTags  = $('#tagCount').val();//alert("TotalTags"+totalTags);
			$('#currentTagID').val(listCounter);
			
			// Previous Next Finish Button.
			if(listCounter=='1'){
				$('#previous').hide();
				$('#finishreqc').hide();
				$('#next').show();
				$('#dropZoneImgDiv').empty();
				$('#'+currentTagVal).show();
				reQCData.setAllTagListToDefault(totalTags);
				reQCData.setTagListToVisited(listCounter);
				reQCData.setSelectedTagListToAtive(currentTagVal);
				reQCData.getReQCImgDataByAjax(currentTagVal);
			}else if(listCounter>1 && listCounter!=totalTags){
				$('#finishreqc').hide();
				$('#previous').show();
				$('#next').show();
				$('#dropZoneImgDiv').empty();
				$('#'+currentTagVal).show();
				//reQCData.actionNextReQCData(vccID,listCounter,currentTagVal,listCounter,checkValidationFlag);
				reQCData.setAllTagListToDefault(totalTags);
				reQCData.setTagListToVisited(listCounter);
				reQCData.setSelectedTagListToAtive(currentTagVal);
				reQCData.getReQCImgDataByAjax(currentTagVal);
			}else if(listCounter==totalTags){
				$('#finishreqc').show();
				$('#previous').show();
				$('#next').hide();
				$('#dropZoneImgDiv').empty();
				reQCData.setAllTagListToDefault(totalTags);
				reQCData.setTagListToVisited(listCounter);
				reQCData.setSelectedTagListToAtive(currentTagVal);
				reQCData.getReQCImgDataByAjax(currentTagVal);
			}
			
		});
	
	},
    
    actionNextReQCData: function(vccID,counter,currentTagVal,orgCounter,checkValidationFlag){
		/**********Start***********/
			//alert(checkValidationFlag);
			$('#previous').show();
            $('#dropZoneImgDiv').empty();
            var totalTags  = $('#tagCount').val();
            var currentTag =  $('#taginput_'+counter).attr('label');
            $('#currentTagID').val(counter);
            //$('#tag_'+currentTag).css("color", "blue");
			$('#tag_'+currentTag).removeClass("re-qc-list-default");
			$('#tag_'+currentTag).addClass("re-qc-list-active");
			
            $('#'+currentTag).show();
			//alert('I am here');
            if(totalTags == counter){
				//alert('I am here-in');
                $('#next').hide();
                $('#finishreqc').show();
               /* $('#finishreqc').click(function(){alert('I am on finish click');
                    $('#tag_'+currentTag).css("color", "green");
					var currentTagVal =  $('#tag_'+orgCounter).attr('label');
                    var weblayout = $('#qcPanelData').val();
                    if(weblayout == 'reQcPanelData'){
                        var url    = "ajax";
                        var name   = "reQcCheck";
                        var params = "name="+name+"&vccID="+vccID+"&tagId="+currentTagVal;
                        $.post(url,params,function(msg){
                            var objReturn = jQuery.parseJSON(msg);
                            if(objReturn.status==true){
                                toastr['success'](objReturn.msg, "success");
								swal({
								  title: "Are you sure?",
								  text: "You want to start QC-3!",
								  type: "warning",
								  allowOutsideClick: true,
								  showCancelButton: true,
								  confirmButtonColor: "#DD6B55",
								  confirmButtonText: "Yes, Start it!",
								  cancelButtonText: "No, cancel please!",
								  closeOnConfirm: true,
								  closeOnCancel: true
								},
								function(isConfirm){
									  if (isConfirm) {
										  window.location.href = GPATH_BASE_REL+'qc/reqcpanel?vcc='+vccID; 
									  }
								  });								
                            }else{
								Common.hideOverlay();
                                toastr['error'](objReturn.msg, "error");
                            }
                        });
                    }
  
                  });*/
              }
              var tagCounter = Number(counter) - 1;
              for(i = 1; i <=tagCounter; i++){
                var value =  $('#taginput_'+i).attr('label');
               // $('#tag_'+value).css("color", "green");
				$('#tag_'+value).removeClass("re-qc-list-active");
				$('#tag_'+value).removeClass("re-qc-list-default");
				$('#tag_'+value).addClass("re-qc-list-visited");
                $('#'+value).hide();
              }
              reQCData.getReQCImgDataByAjax(currentTag);
		/**********END*************/
	},
	
	setAllTagListToDefault:function(totalCount){
		var tagCounter = totalCount;
		for(i = 1; i <=tagCounter; i++){
			var value =  $('#taginput_'+i).attr('label');
			$('#tag_'+value).removeClass("re-qc-list-active");
			$('#tag_'+value).removeClass("re-qc-list-visited");
			$('#tag_'+value).addClass("re-qc-list-default");
			$('#'+value).hide();
		}
	},
	setTagListToVisited:function(tillCount){
		var tagCounter = tillCount;
		for(i = 1; i <=tagCounter; i++){
			var value =  $('#taginput_'+i).attr('label');
			$('#tag_'+value).removeClass("re-qc-list-active");
			$('#tag_'+value).removeClass("re-qc-list-default");
			$('#tag_'+value).addClass("re-qc-list-visited");
			$('#'+value).hide();
		}
	},
	setSelectedTagListToAtive:function(currentTag){
		$('#tag_'+currentTag).removeClass("re-qc-list-visited");
		$('#tag_'+currentTag).removeClass("re-qc-list-default");
		$('#tag_'+currentTag).addClass("re-qc-list-active");
		$('#'+currentTag).show();
	},
	
    getReQCImgDataByAjax: function(currentTag){
			Common.showOverlay();
            var vccID = $('#vcc').val();
            var url   = "ajax";
            var name  = "getTransientReQcData";
            var params = "currentTag="+currentTag+"&name="+name+"&vccID="+vccID;
            $.post(url,params,function(jsonReQcData){
                var reQCImgData = $.parseJSON(jsonReQcData); 
                $.each(reQCImgData, function(aind, aval){
                    $('#dropZoneImgDiv').append('<div class="rc-list-box re-qc-img-box tagImgCls cls_'+aval.imgNameBase+'"><input type="hidden" name="image'+aval.imgNameBase+'" value="'+aval.imgPath+'"/><div class="rc-list-thumb clearfix posrelative"><div class="del del_'+aval.imgNameBase+'"><div class="del-txt clearfix">Are you sure you want to delete?<ul><li><div data-imgname="cls_'+aval.imgNameBase+'" class="delbox deleteQCImg" data-imagefullpath = "'+aval.absPath+''+aval.imgPath+'" data-imagefullname="'+aval.imgPath+'" data-delete-status="1"><b>Yes</b></div></li><li><div class="delbox nodeleteclr" rel="del_'+aval.imgNameBase+'"><b>No</b></div></li></ul></div></div><div class="fa fa-trash" rel="del_'+aval.imgNameBase+'"></div><div class="rc-img-thumb"><a href="#" data-target="#model-documentChecklist2" data-toggle="modal"><img class="img-responsive" src="'+aval.relPath+''+aval.imgPath+'"></a></div></div></div>');
                });
				
				Common.hideOverlay();
            });
  },
  
    updateReQcImageUploadStatus: function(){
		var vccID = $('#vcc').val();
		var url    = "ajax";
		var name   = "reQcImageUploadStatus";
		var params = "name="+name+"&vccID="+vccID+"&Status=4";
		$.post(url,params,function(msg){
			var objReturn = jQuery.parseJSON(msg);//alert(objReturn.status);
			if(objReturn.status==true){
				toastr['success'](objReturn.msg, "success");
				$(window.opener.document).find('.doqcedit'+vccID).after( "&nbsp;&nbsp;<label class='label label-success'>Done</label>" );
				$(window.opener.document).find('.doqcele'+vccID).remove('.doqcele'+vccID);
				$(window.opener.document).find('.doqcedit'+vccID).remove('.doqcedit'+vccID);
				var objWindow = window.open(location.href, "_self");
				objWindow.close();
			}else{
				toastr['error'](objReturn.msg, "error");
			}
		});
	}
};

	function checkQc(abc,temp){
		var win = window.open(abc, '_blank');
		if(win){
			//Browser has allowed it to be opened
			win.focus();
		}else{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
	}

        

       $('#field_regno').keydown(function (e) {
           if (e.shiftKey || e.ctrlKey || e.altKey) {
            e.preventDefault();
            } else {
            var key = e.keyCode;
            if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
            e.preventDefault();
            }
            }
       });

         
    $('#field_km').keydown(function (event) {
       var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
            event.preventDefault();
        }
    });


        $(document).ready(function() {
            $('#field_variant').change(function() {
             var variant = $('#field_variant').val();
             $.ajax({
                 type : "POST",
                 url : "/stockqc/powervariant",
                 data : "varient="+variant,
                  success: function(msg){
                      $("#field_power").attr('value',msg);
                  }
             })
            });
       });

//    $('#field_version').on('change',function(){
//    var selected = $("#field_version option:selected").val();
//    var usedCarID = $("#usedCarID").val();
//        $.ajax({
//         type:'POST',
//         url:"/stockqc/updatevariantonprofilepic",
//         data:{version:selected,usedCarID:usedCarID},
//        success: function(result){
//          console.log('version updated');  
//    }
//    }); 
// });
