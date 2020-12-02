function thtmleditor_enable_field(form_name, field) {
    setTimeout(function(){ $('form[name='+form_name+'] [name='+field+']').next().find('.note-editable').attr('contenteditable', true); },1);
}

function thtmleditor_disable_field(form_name) {
    tinymce.activeEditor.setMode('readonly');
    setTimeout(function(){ tinymce.activeEditor.setMode('readonly'); },500); 
}

function thtmleditor_clear_field(form_name, field) {
    setTimeout(function(){ $('form[name='+form_name+'] [name='+field+']').code(''); },1);    
}

function thtmleditor_start(objectId, width, height, lang, options) {
    
    var attributes = {
        selector: '#'+objectId,
        language: 'pt_BR',
    width: width,
    height: height,
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    },
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table emoticons template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons'}
    },
    menubar: 'favs file edit view insert format tools table help'
   
    };
    
    options = Object.assign(attributes, JSON.parse( options) );
    
    
  
    
   
    tinymce.init(options);
   
    
   
}

function thtml_editor_reload_completion(field, options)
{
    objectId = $('[name='+field+']').attr('id');
    setTimeout( function() {
        summernote_wordlist[objectId] = options;
    }, 1);
}