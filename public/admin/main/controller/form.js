/* 1 定义Controller*/
Alpaca.MainModule.FormController = {

    //index,  默认渲染到
    indexAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {

            if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
                CKEDITOR.tools.enableHtml5Elements( document );

            // The trick to keep the editor in the sample quite small
            // unless user specified own height.
            CKEDITOR.config.height = 150;
            CKEDITOR.config.width = 'auto';

            var initSample = ( function() {
                var wysiwygareaAvailable = isWysiwygareaAvailable(),
                    isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

                return function() {
                    var editorElement = CKEDITOR.document.getById( 'editor' );

                    // :(((
                    if ( isBBCodeBuiltIn ) {
                        editorElement.setHtml(
                            'Hello world!\n\n' +
                            'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
                        );
                    }

                    // Depending on the wysiwygare plugin availability initialize classic or inline editor.
                    if ( wysiwygareaAvailable ) {
                        CKEDITOR.editorConfig = function( config ) {
                            config.toolbar = [
                                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                                { name: 'editing', items: [ 'Scayt' ] },
                                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
                                { name: 'forms', items: [ 'Form'] },
                                { name: 'tools', items: [ 'Maximize' ] },
                                { name: 'document', items: [ 'Source' ] },
                                '/',
                                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
                                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                                { name: 'styles', items: [ 'Styles', 'Format' ] },
                                { name: 'about', items: [ 'About' ] }
                            ];
                        };

                        CKEDITOR.replace( 'editor' );
                    } else {
                        editorElement.setAttribute( 'contenteditable', 'true' );
                        CKEDITOR.inline( 'editor' );

                        // TODO we can consider displaying some info box that
                        // without wysiwygarea the classic editor may not work.
                    }
                };

                function isWysiwygareaAvailable() {
                    // If in development mode, then the wysiwygarea must be available.
                    // Split REV into two strings so builder does not replace it :D.
                    if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
                        return true;
                    }

                    return !!CKEDITOR.plugins.get( 'wysiwygarea' );
                }
            } )();

            initSample();
        });
        return view;
    },

    //ueditor,  ueditor富文本编辑器
    ueditorAction: function (){
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var ue = UE.getEditor("ue-content");
        });
        return view;
    }
};