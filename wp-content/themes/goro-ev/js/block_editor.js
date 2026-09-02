/**
 * カスタムブロック
 * attributesで、値を設定し、editで編集画面に反映、saveで保存データに反映
 * classNameで指定したclassをlayout.cssで設定する
 * https://www.webdesignleaves.com/pr/wp/wp_block_basic.html
 * 画像のアップロードができない。以下を参考にしている途中
 * https://www.webopixel.net/wordpress/1439.html
 */
(function(blocks, element, components, blockEditor)
{
	var el = element.createElement;
  var TextControl = components.TextControl;
  var RichText = blockEditor.RichText ;

	//registerBlockType でブロックを登録
	blocks.registerBlockType(
		// block_editor.phpの()と対応
		'tare-blocks/tare-sample-block',
		{
			title: 'Tare sample Block',
			// icon: https://developer.wordpress.org/resource/dashicons/#media-code
			icon: 'universal-access-alt',
			// categories: common, formatting, layout, embed, widgets
			category: 'layout',
      example: {},
			attributes: {
				titleText: {
					type: 'string',
					default: '',
					source: 'html',
					selector:'h3.tare_title_text'
				},
				subTitleText: {
					type: 'string',
					default: ''
				},
				contentText: {
          type: 'array',
					default: '',
          source: 'children',
          selector: 'div.tare_content_text',
				},
				contentList: {
          type: 'array',
					default: '',
          source: 'children',
          selector: 'ul.tare_content_list',
				},

/*
				//画像
				mediaID: {
					type: 'number',
					default: 0
				},
				mediaURL: {
					type: 'string',
					source: 'attribute',
					attribute: 'src',
					selector: '.card_image'
				},
				mediaALT: {
					type: 'string',
					source: 'attribute',
					attribute: 'alt',
					selector: '.card_image'
				}
*/
			},

			// 編集画面
			edit: function(props)
			{
				//console.log(props);

				return el(
					'div',
					{
						className: "tare-sample-classname",
					},
					[
						el(
							RichText,
							{
								tagName: 'h3',
								placeholder: 'enter title',
								onChange: function (newText) {props.setAttributes({ titleText: newText });},
								value: props.attributes.titleText,
								className: "tare_title_text"
							}
						),
						el(
							TextControl,
							{
								placeholder: 'enter sub title',
								onChange: function (newText) {props.setAttributes({ subTitleText: newText });},
								value: props.attributes.subTitleText
							}
						),
						el(
							RichText,
							{
								tagName: 'div',
								placeholder: 'enter text',
								onChange: function (newText) {props.setAttributes({ contentText: newText });},
								value: props.attributes.contentText,
								multiline: 'p',
                className: 'tare_content_text'
							}
						),
						el(
							RichText,
							{
								tagName: 'ul',
								placeholder: 'enter each',
								onChange: function (newText) {props.setAttributes({ contentList: newText });},
								value: props.attributes.contentList,
								multiline: 'li'
							}
						)
					]
				);
			},

			// 保存される内容
			save: function(props)
			{
				//console.log(props);
				return el(
					'div',
					{
						className: "tare-sample-classname",
					},
					[
						el(
							RichText.Content,
							{
								tagName: 'h3',
								className: 'tare_title_text',
								value: props.attributes.titleText
							}
						),
						el(
							"span",
							{
								className: 'tare_subtitle_text',
							},
							props.attributes.subTitleText
						),
						el(
							RichText.Content,
							{
								tagName: 'div',
                className: 'tare_content_text',
								value: props.attributes.contentText
							}
						),
						el(
							RichText.Content,
							{
								tagName: 'ul',
                className: 'tare_content_list',
								value: props.attributes.contentList
							}
						)
					]
				);
			},
		}
	);
}(
	window.wp.blocks,
	window.wp.element,
  window.wp.components,
  window.wp.blockEditor
)
);
