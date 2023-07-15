$(function(){
    //EXIBIR MODAIS
    $("#btn_add_course").click(function(){
        clearErrors();
        $("#form_course")[0].reset();
        $("#course_img_path").attr("src","");
        $("#modal_course").modal('show');
    })

    $("#btn_add_member").click(function(){
        clearErrors();
        $("#form_member")[0].reset();
        $("#member_photo_path").attr("src","");
        $("#modal_member").modal('show');
    })

    $("#btn_add_user").click(function(){
        clearErrors();
        $("#form_user")[0].reset();
        $("#modal_user").modal('show');
    })

/*    $("#btn_add_member").click(function(){
        $("#modal_member").modal('show');
    })

    $("#btn_add_user").click(function(){
        $("#modal_user").modal('show');
    });
*/
    $("#btn_upload_course_img").change(function(){
        uploadImg($(this),$("#course_img_path"),$("#course_img"));
    });

    $("#btn_upload_member_photo").change(function(){
        uploadImg($(this),$("#member_photo_path"),$("#member_photo"));
    });

    $("#form_course").submit(function(){
        console.log("Formulário submetido!");
        $.ajax({
			type: "POST",
			url: BASE_URL + "areaRestrita/ajax_save_course",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_course").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					$("#modal_course").modal("hide");
					Swal.fire("Sucesso!","Curso salvo com sucesso!", "success");
					dt_course.ajax.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
    });

    $("#form_member").submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "areaRestrita/ajax_save_member",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_member").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					$("#modal_member").modal("hide");
					Swal.fire("Sucesso!","Membro salvo com sucesso!", "success");
					dt_member.ajax.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});

    $("#form_user").submit(function(){
        console.log("Formulário submetido!");
        $.ajax({
			type: "POST",
			url: BASE_URL + "areaRestrita/ajax_save_user",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_user").siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					$("#modal_user").modal("hide");
					Swal.fire("Sucesso!","Curso salvo com sucesso!", "success");
					dt_user.ajax.reload();
					//JEITO 2 DEIXAR O 2 POR ENQUANTO 1 AS VEZES FUNCIONA E AS VEZES ANO
					$("#dt_user").DataTable().draw(); 
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
    });


    $("#btn_your_user").click(function(){
        $.ajax({
			type: "POST",
			url: BASE_URL + "areaRestrita/ajax_get_user_data",
			dataType: "json",
			data: {"user_id": $(this).attr("user_id")},
			success: function(response) {
				clearErrors();
				$("#form_user")[0].reset();
				$.each(response["input"],function(id,value){
					$("#"+id).val(value)
				});
				$("#modal_user").modal('show');
			}
		})

		return false;
    });

	function active_btn_course(){
		$(".btn-edit-course").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "areaRestrita/ajax_get_course_data",
				dataType: "json",
				data: {"course_id": $(this).attr("course_id")},
				success: function(response) {
					clearErrors();
					$("#form_course")[0].reset();
					$.each(response["input"],function(id,value){
						$("#"+id).val(value)
					});
					$("#course_img_path").attr("src",response["img"]["course_img_path"]);
					$("#modal_course").modal('show');
				}
			})
		});

		$(document).on('click', '.btn-del-course', function() {
			var course_id = $(this).attr("course_id");
		  
			Swal.fire({
			  title: "Atenção",
			  text: "Deseja deletar esse curso?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#d9534f",
			  confirmButtonText: "SIM",
			  cancelButtonText: "NAO",
			  closeOnConfirm: true,
			  closeOnCancel: true
			}).then((result) => {
			  if (result.value) {
				$.ajax({
				  type: "POST",
				  url: BASE_URL + "areaRestrita/ajax_delete_course_data",
				  dataType: "json",
				  data: {
					"course_id": course_id
				  },
				  success: function(response) {
					Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
					//dt_course.ajax.reload();
					//jeito 2
					$("#dt_course").DataTable().draw(); 
				  }
				});
			  }
			});
		  });
	}

	function active_btn_member(){
		$(".btn-edit-member").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "areaRestrita/ajax_get_member_data",
				dataType: "json",
				data: {"member_id": $(this).attr("member_id")},
				success: function(response) {
					clearErrors();
					$("#form_member")[0].reset();
					$.each(response["input"],function(id,value){
						$("#"+id).val(value)
					});
					$("#member_photo_path").attr("src",response["img"]["member_photo_path"]);
					$("#modal_member").modal('show');
				}
			})
		});

		$(document).on('click', '.btn-del-member', function() {
			var member_id = $(this).attr("member_id");
		  
			Swal.fire({
			  title: "Atenção",
			  text: "Deseja deletar esse membro da equipe?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#d9534f",
			  confirmButtonText: "SIM",
			  cancelButtonText: "NAO",
			  closeOnConfirm: true,
			  closeOnCancel: true
			}).then((result) => {
			  if (result.value) {
				$.ajax({
				  type: "POST",
				  url: BASE_URL + "areaRestrita/ajax_delete_member_data",
				  dataType: "json",
				  data: {"member_id": member_id},
				  success: function(response) {
					Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
					dt_member.ajax.reload();
				  }
				});
			  }
			});
		  });
	}

	function active_btn_user(){
		$(".btn-edit-user").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "areaRestrita/ajax_get_user_data",
				dataType: "json",
				data: {"user_id": $(this).attr("user_id")},
				success: function(response) {
					clearErrors();
					$("#form_user")[0].reset();
					$.each(response["input"],function(id,value){
						$("#"+id).val(value)
					});
					$("#modal_user").modal('show');
				}
			})
		});
		$(document).on('click', '.btn-del-user', function() {
			var user_id = $(this).attr("user_id");
		  
			Swal.fire({
			  title: "Atenção",
			  text: "Deseja deletar esse usuario?",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#d9534f",
			  confirmButtonText: "SIM",
			  cancelButtonText: "NAO",
			  closeOnConfirm: true,
			  closeOnCancel: true
			}).then((result) => {
			  if (result.value) {
				$.ajax({
				  type: "POST",
				  url: BASE_URL + "areaRestrita/ajax_delete_user_data",
				  dataType: "json",
				  data: {"user_id": user_id},
				  success: function(response) {
					Swal.fire("Sucesso!", "Ação executada com sucesso", "success");
					dt_user.ajax.reload();
					//JEITO 2 DEIXAR O 2 POR ENQUANTO 1 AS VEZES FUNCIONA E AS VEZES ANO
					$("#dt_user").DataTable().draw(); 
				  }
				});
			  }
			});
		  });
	}

	var dt_course = $("#dt_course").DataTable({
		language: linguagemData,
		"autoWidth":false,
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":  BASE_URL + "areaRestrita/ajax_list_course",
			"type":"POST"
		},
		"columnDefs":[
			{targets:"no-sort",orderable:false},
			{ targets:"dt-center",className:"dt-center"},
		],
		"drawCallback":function(){
			active_btn_course();
		}

	})

	var dt_member = $("#dt_team").DataTable({
		language: linguagemData,
		"autoWidth":false,
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":  BASE_URL + "areaRestrita/ajax_list_member",
			"type":"POST"
		},
		"columnDefs":[
			{targets:"no-sort",orderable:false},
			{ targets:"dt-center",className:"dt-center"},
		],
		"drawCallback":function(){
			active_btn_member();
		}
		
	})

	var dt_user = $("#dt_users").DataTable({
		language: linguagemData,
		"autoWidth":false,
		"processing":true,
		"serverSide":true,
		"ajax":{
			"url":  BASE_URL + "areaRestrita/ajax_list_users",
			"type":"POST"
		},
		"columnDefs":[
			{targets:"no-sort",orderable:false},
			{ targets:"dt-center",className:"dt-center"},
		],
		"drawCallback":function(){
			active_btn_user();
		}

	})

}
);

