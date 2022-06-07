document.addEventListener("DOMContentLoaded", function() {
	let access_list = [];
	let chbox = $(".chbox-menu");

	$(".child-chbox-menu").change((e) => {
		let rowkey = e.currentTarget.attributes[0].nodeValue;
		let parentid = $(`#child-checkbox-${rowkey}`).attr("parentid");
		let ischecked = $(`#child-checkbox-${rowkey}`).prop("checked");

		if(ischecked) {
			access_list.push({
					parentid : parentid, 
					childid : rowkey
			});
		} else {
			for(i = 0; i < access_list.length; i++) {
				if(access_list[i].parentid == parentid && access_list[i].childid == rowkey) {
					access_list.splice(i, 1);
				}
			}
		}
	});

	$(".child-chbox-menu").each((i, e) => {
		let childid =$(`#child-checkbox-${i+1}`).attr("rowkey");
		let parentid = $(`#child-checkbox-${i+1}`).attr("parentid");
		let ischecked = $(`#child-checkbox-${i+1}`).prop("checked");

		if (ischecked) {
			access_list.push({
					parentid : parentid, 
					childid : childid
			});
		}
	});

	$("input[name='role']").focus();

	$("#btnSave").click((e) => {
		e.preventDefault();

		let roleid = $("input[name='roleid']").val();
		let role = $("input[name='role']").val();

		let role_info_arr = [];
		let role_info_obj = {
			roleid : roleid,
			role : role
		};

		role_info_arr.push(role_info_obj);
		postData("/roles/saveRole", {data : access_list, roleinfo : role_info_arr})
	  .then(res => {
  		$("input[name='roleid']").val(res.data.roleid);
  		$("input[name='role']").val(res.data.role);
	  	notify({status : res.status, message : res.msg});
	  }).catch((error) => {
	    console.log(error);
	  });
	});
});