import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

var allEditors = document.querySelectorAll('.ckeditor5');
for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(allEditors[i]);
}
