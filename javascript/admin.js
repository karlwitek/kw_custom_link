
wp.blocks.registerBlockType("kwplugin/linkblock", {
  title: 'KW Custom Link',
  icon: 'smiley',
  category: 'common',
  attributes: {
    urlOrSlug: {type: 'string'},
    title: {type: 'string'},
    description: {type: 'string'},
    pageAnchor: {type: 'string'}
  },
  edit: function(props) {

    function updateTitle(event) {
      props.setAttributes({title: event.target.value});
    };

    function updateURL(event) {
      props.setAttributes({urlOrSlug: event.target.value});
    };

    function updateText(event) {
      props.setAttributes({description: event.target.value});
    };

    function updateAnchor(event) {
      props.setAttributes({pageAnchor: event.target.value});
    };

    return wp.element.createElement('div', { className: 'kwcl-custom-block'}, [
      wp.element.createElement('input', { name: 'title', type: 'text', value: props.attributes.title, placeholder: 'title', onChange: updateTitle }, null),
      wp.element.createElement('input', { name: 'linkurl', type: 'text', value: props.attributes.urlOrSlug, placeholder: 'url or page slug', onChange: updateURL }, null),
      wp.element.createElement('input', { name: 'pageAnchor', type: 'text', value: props.attributes.pageAnchor, placeholder: 'anchor from editor', onChange: updateAnchor }, null),
      wp.element.createElement('textarea', { name: 'description', value: props.attributes.description, placeholder: 'description', onChange: updateText}, null)
    ]);

  },
  save: function(props) {
    return null;
  }

});