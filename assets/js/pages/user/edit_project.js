function max_length(e) {
    if ($(e).val() != "") {
        if (parseInt($(e).val()) < 1 || parseInt($(e).val()) >= 30) {
            $('.delivery_days_error').show();
            $('.validdays').attr('disabled', 'disabled');
            $(e).val('');
        } else {
            $('.delivery_days_error').hide();
            $('.validdays').removeAttr('disabled');
        }
    }
}

function edit_projects_save() {

    var error = 0;
    var project_title = $('#project_title').val().trim();

    if (project_title == "") {
        $('.project_title_error').show();
        error = 1;
    } else {
        $('.project_title_error').hide();
    }

    if ($('.project_title_valid').val() == 1) {
        error = 1;
        $('.project_title_already_error').show();
    } else {
        $('.project_title_already_error').hide();
    }


    if ($('#project_price').val() == "") {
        error = 1;
        $('.project_price_error').show();
    } else {
        $('.project_price_error').hide();
    }

    if ($('#delivering_time').val() == "") {
        error = 1;
        $('.main_delivery_days_error').show();
    } else {
        $('.main_delivery_days_error').hide();
    }

    if ($('#delivering_time').val() != "") {

        if (parseInt($('#delivering_time').val()) >= 30) {
            error = 1;
            $('.delivery_days_error').show();
        } else {
            $('.delivery_days_error').hide();
        }
    }

    if ($('#project_category_id').val() == "") {
        error = 1;
        $('.project_category_id_error').show();
    } else {
        $('.project_category_id_error').hide();
    }

    if ($('#project_details').val() == "") {
        error = 1;
        $('.project_details_error').show();
    } else {
        $('.project_details_error').hide();
    }

    if (error == 0) {
        $('#project').submit();
    } else {
        return false;
    }
}

function checkinput(e) {
    var days = $(e).val();
    days = days.replace(/[^0-9]/g, '');
    $(e).val(days);
}

function dropHandler(ev) {
    console.log('File(s) dropped');
  
    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();
  
    if (ev.dataTransfer.items) {
      // Use DataTransferItemList interface to access the file(s)
      for (var i = 0; i < ev.dataTransfer.items.length; i++) {
        // If dropped items aren't files, reject them
        if (ev.dataTransfer.items[i].kind === 'file') {
          var file = ev.dataTransfer.items[i].getAsFile();
          console.log('... file[' + i + '].name = ' + file.name);
        }
      }
    } else {
      // Use DataTransfer interface to access the file(s)
      for (var i = 0; i < ev.dataTransfer.files.length; i++) {
        console.log('... file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
      }
    }
}

function dragOverHandler(ev) {
    console.log('File(s) in drop zone'); 

    // Prevent default behavior (Prevent file from being opened)
    ev.preventDefault();
}

function change_file(eLabel)
{
    var eDeletedFiles = document.getElementById('deleted_files');
    var eAttachBlock = eLabel.closest('.attach-block');
    var eFileLink = eAttachBlock.children[0];
    var eCheckBox = eLabel.children[0];
    if(eCheckBox.checked)
    {
        var string = eDeletedFiles.value.replace(eFileLink.getAttribute("attach_name") + '#', '');
        eDeletedFiles.value = string;
    }
    else
    {
        eDeletedFiles.value = eDeletedFiles.value + eFileLink.getAttribute("attach_name") + '#';
    }
}

function add_file(eButton)
{
    var eParentBlock = eButton.closest('.file-upload-block');
 
    var eFileBlock = document.createElement('div');
    eParentBlock.appendChild(eFileBlock);
    eFileBlock.className = 'file-block';
 
    var eFile = document.createElement('input');
    eFileBlock.appendChild(eFile);
    eFile.setAttribute('type', 'file');
    eFile.className = 'file-input';

    var eFileName = document.createElement('div');
    eFileBlock.appendChild(eFileName);
    eFileName.setAttribute('type', 'file');
    eFileName.className = 'file-name';

    var eFileSize = document.createElement('div');
    eFileBlock.appendChild(eFileSize);
    eFileSize.setAttribute('type', 'file');
    eFileSize.className = 'file-size';

    var eFileDelete = document.createElement('div');
    eFileBlock.appendChild(eFileDelete);
    eFileDelete.setAttribute('type', 'file');
    eFileDelete.className = 'file-delete';
    eFileDelete.textContent = 'X';

    eFileDelete.onclick = function(){
        var eBlock = this.closest('.file-block');
        var eUploadfiles = document.getElementById('upload_files');
        eUploadfiles.value = eUploadfiles.value.replace(eBlock.children[0].name+"`",'');
        eBlock.remove();
    }

    eFile.oninput = function(){
        var eUploadfiles = document.getElementById('upload_files');
        var eBlock = this.closest('.file-block');
        if(this.files.length == 0)
        {
            eBlock.remove();
        }
        else{
            var file = this.files[0];
            eBlock.children[0].name = file.name;
            eBlock.children[1].textContent = file.name;
            eBlock.children[2].textContent = file.size+"byte";
            eUploadfiles.value = eUploadfiles.value+file.name+"`";
        }
    }
    eFile.click();
}