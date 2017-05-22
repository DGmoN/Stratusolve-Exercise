
    var currentTaskId = -1;
    $('#myModal').on('show.bs.modal', function (event) {
        var triggerElement = $(event.relatedTarget); // Element that triggered the modal
        var modal = $(this);
        if (triggerElement.attr("id") == 'newTask') {
            mkNewTask(modal);
        } else {
			modal.find('.modal-title').text('Task details');
			$('#deleteTask').show();
			currentTaskId = triggerElement.attr("id");
            modalUpdateTask(modal, triggerElement);
        }
    });
	
	// prep modal for Update Task	
	function modalUpdateTask(modal, triggerElement){
		
		// My addition
		var name	=	triggerElement.find(".list-group-item-heading").html();
		var disc	=	triggerElement.find(".list-group-item-text").html();
		modal.find("#InputTaskName").val(name);
		modal.find("#InputTaskDescription").val(disc);
		// End of my addition
		
		console.log('Task ID: '+triggerElement.attr("id"));
	}
	
	// prep modal for new taks
	function mkNewTask(modal){
		modal.find('.modal-title').text('New Task');
			
		modal.find("#InputTaskName").val("");
		modal.find("#InputTaskDescription").val("");
		
		$('#deleteTask').hide();
	}
	
    $('#saveTask').click(function() {
        //Assignment: Implement this functionality
        alert('Save... Id:'+currentTaskId);
		var mod = $('#myModal');
        mod.modal('hide');
		var Action = "save";
		if(currentTaskId==-1){
			Action = "create";
		}
		
		$.post("update_task.php", {action: Action, 
									TId: currentTaskId, 
									TName: mod.find("#InputTaskName").val(),
									TDisc: mod.find("#InputTaskDescription").val()},
									handleResponce);
									
        
    });
    $('#deleteTask').click(function() {
        //Assignment: Implement this functionality
        alert('Delete... Id:'+currentTaskId);
        $('#myModal').modal('hide');
		$.post("update_task.php", {action: "del", 
									TId: currentTaskId}, handleResponce);
        updateTaskList();
    });
	
	function handleResponce(jso){
		var obj = $.parseJSON(jso);
		if(obj.status == '1'){
			alert("Sucsessful");
		}else{
			alert("Not so sucsessful\n"+obj.cause);
		}
		updateTaskList();
	}
	
    function updateTaskList() {
        $.post("list_tasks.php", function( data ) {
            $( "#TaskList" ).html( data );
        });
    }
    updateTaskList();
