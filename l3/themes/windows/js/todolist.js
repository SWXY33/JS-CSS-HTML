
// 执行渲染函数
RenderingList(list);

// layui
layui.use('form', function () {
	var form = layui.form;

	// 多选判断逻辑
	form.on('checkbox(todo)', function (data) {
		var newArr = [];
		if($('#switch').is(':checked')){
			
			var nowid=$(data.elem).parent('li').attr('data-id');

			$.ajax({
				url: "/index.php/todolist/ajax_updata",
				data: {done:data.elem.checked?'1':'0',id:nowid},
				type:'post',
				dataType:'json',
				success:function(data){
					if (data.code=='100') {

					}else{
	
					}
				},
				error:function(data){
					layer.msg('失败：'+data.msg,{icon:5,time:3000});
				}
			});
			
			if (data.elem.checked) {
				
				list[$(data.elem).parent('li').attr('data-index')].done = 1;
				
				for(var i=0; i<list.length;i++){
					if (list[i].done==0) newArr.push(list[i]);
				}
	
				for(var i=0; i<list.length;i++){
					if (list[i].done==1) newArr.push(list[i]);
				}

				// 执行渲染函数
				list = newArr;
				RenderingList(list);
				
			}else{
				list[$(data.elem).parent('li').attr('data-index')].done = 0;

				// 先执行排序方法
				RenderingList(getMaxSort(list));

				for(var i=0; i<list.length;i++){
					if (list[i].done==0) newArr.push(list[i]);
				}
	
				for(var i=0; i<list.length;i++){
					if (list[i].done==1) newArr.push(list[i]);
				}

				// 执行渲染函数
				list = newArr;
				RenderingList(list);
				
			}
		}else{
			if (data.elem.checked) {
				$(data.elem).parent('li').addClass('has_done');
				// 获取该行的data-index
				list[$(data.elem).parent('li').attr('data-index')].done = 1;
				// 执行渲染函数
				RenderingList(list);
			}else{
				$(data.elem).parent('li').removeClass('has_done');
				// 获取该行的data-index
				list[$(data.elem).parent('li').attr('data-index')].done = 0;
				// 执行渲染函数
				RenderingList(list);
			}
		}
	});

	// 已完成项目移动到最后
	form.on('switch(tolast)', function (data) {
		var newArr = [];
		if (data.elem.checked) {
			for(var i=0; i<list.length;i++){
				if (list[i].done==0) newArr.push(list[i]);
			}

			for(var i=0; i<list.length;i++){
				if (list[i].done==1) newArr.push(list[i]);
			}

			// 执行渲染函数
			list = newArr;
			RenderingList(list);
		} else {
			// 执行排序方法
			RenderingList(getMaxSort(list));
		}
	});
});

// 添加事件
$('#todobtn').on('click', function () {
	var val = $('#todotext').val();
	if (!val) {
		layer.alert('请输入内容');
		return false;
	}

	if (list.length >= 0) {

        $.ajax({
            url: "/index.php/todolist/ajax_add",
            data: {content:val},
            type:'post',
            dataType:'json',
            success:function(data){
                if (data.code=='100') {
				list.unshift({ content: val, done: 0, id: data.id  });
				RenderingList(list);
				layer.msg('新增成功',{icon:1,time:3000});
                }else{

                }
            },
            error:function(data){
                layer.msg('失败：'+data.msg,{icon:5,time:3000});
            }
        });

		
	} else {
		// 新增到数组当中
		list.unshift({ content: val, done: 0, id: 0 });
	}

	// 执行渲染函数
	RenderingList(list);

	// 清空表单
	$('#todotext').val('');
})

// 渲染函数
function RenderingList(arr) {
	// 先清空html结构
	$('.mainlist').html('');

	if (arr.length == 0) {
		$('.mainlist').append('<li>您的待办事项列表是空的。</li>')
	} else {
		// 根据数据渲染html
		for(var i=0; i<arr.length;i++){
			if (arr[i].done==1) {
				$('.mainlist').append('<li class="no_done has_done" data-id="' + arr[i].id + '" data-index="' + i + '">' +
					'<input content="checkdone" type="checkbox" vaule="' + arr[i].id + '" checked="checked" lay-skin="primary" lay-filter="todo">' +
					'<span class="text">' + arr[i].content + '</span> ' +
					'<a href="javascript:;" onClick="del(' + arr[i].id + ',' + i + ')">删除</a>' +
					'</li>');
			} else {
				$('.mainlist').append('<li class="no_done" data-id="' + arr[i].id + '" data-index="' + i + '">' +
					'<input content="checkdone" type="checkbox" vaule="' + arr[i].id + '" lay-skin="primary" lay-filter="todo">' +
					'<span class="text">' + arr[i].content + '</span> ' +
					'<a href="javascript:;" onClick="del(' + arr[i].id + ',' + i + ')">删除</a>' +
					'</li>');
			}
		}

		// 刷新表单状态
		layui.use('form', function () {
			var form = layui.form;
			form.render();
		})
	}
}

// 执行删除函数
function del(data_id,index_id) {

	$.ajax({
		url: "/index.php/todolist/ajax_del",
		data: {id:data_id},
		type:'post',
		dataType:'json',
		success:function(data){
			if (data.code=='100') {
	            layer.msg('删除成功',{icon:1,time:3000});
			}else{

			}
		},
		error:function(data){
			layer.msg('失败：'+data.msg,{icon:5,time:3000});
		}
	});

	// 根据索引删除数组的某个值
	list.splice(index_id, 1);
	// 渲染数据
	RenderingList(list);
	
}


// 排序 大 -> 小
function getMaxSort(arr) {
	var max
	for (var i = 0; i < arr.length; i++) {
		for (var j = i; j < arr.length; j++) {
			if (arr[i].id < arr[j].id) {
				max = arr[j]
				arr[j] = arr[i]
				arr[i] = max
			}
		}
	}
	return arr
}