<?php
namespace Clito;

class InitACF
{
  public static function go()
  {
    if( function_exists('acf_add_local_field_group') ):

      acf_add_local_field_group(array(
        'key' => 'group_5d4ae08477b44',
        'title' => 'Common',
        'fields' => array(
          array(
            'key' => 'field_5d4ae5f7a5189',
            'label' => 'Creator(s)',
            'name' => 'creator',
            'type' => 'post_object',
            'instructions' => 'Creator of this ressource.
      Choose anonymous if unknown.
      If the creator has not yet been registerd, open a new window and create one before going on with that form.',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'post_type' => array(
              0 => 'creator',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 1,
            'return_format' => 'object',
            'ui' => 1,
          ),
          array(
            'key' => 'field_5d5176a34f3d6',
            'label' => 'Publication date',
            'name' => 'publication_date',
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'display_format' => 'd/m/Y',
            'return_format' => 'd/m/Y',
            'first_day' => 1,
          ),
          array(
            'key' => 'field_5e2456cf93955',
            'label' => 'Ignore day',
            'name' => 'ignore_day',
            'type' => 'checkbox',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
              array(
                array(
                  'field' => 'field_5d5176a34f3d6',
                  'operator' => '!=empty',
                ),
              ),
            ),
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'choices' => array(
              'ignoreday' => 'If you don\'t have a precise date, check this box and the day won\'t be displayed.',
            ),
            'allow_custom' => 0,
            'default_value' => array(
            ),
            'layout' => 'horizontal',
            'toggle' => 0,
            'return_format' => 'label',
            'save_custom' => 0,
          ),
          array(
            'key' => 'field_5d4ae78ab142d',
            'label' => 'Mature content',
            'name' => 'mature',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => 'field_5d51cc2af5675',
            'label' => 'Free content',
            'name' => 'free_content',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 1,
            'ui' => 1,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
          array(
            'key' => 'field_5d52af1a881a0',
            'label' => 'Review',
            'name' => 'review',
            'type' => 'textarea',
            'instructions' => 'Why do you like this resource ?',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => 5,
            'new_lines' => '',
          ),
          array(
            'key' => 'field_5e245aad9afff',
            'label' => 'Related content',
            'name' => 'related_content',
            'type' => 'post_object',
            'instructions' => 'Contents related to this one that will be suggested to the viewer.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'post_type' => array(
              0 => 'res',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 1,
            'return_format' => 'object',
            'ui' => 1,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'res',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'modified' => 1579440905,
      ));

      acf_add_local_field_group(array(
        'key' => 'group_5d52954a52cb4',
        'title' => 'Creator',
        'fields' => array(
          array(
            'key' => 'field_5d52955155f41',
            'label' => 'Website',
            'name' => 'creator_site',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'creator',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'modified' => 1579440611,
      ));

      acf_add_local_field_group(array(
        'key' => 'group_5d517a6b2cac9',
        'title' => 'Link',
        'fields' => array(
          array(
            'key' => 'field_5d517a6e83607',
            'label' => 'Link',
            'name' => 'link',
            'type' => 'url',
            'instructions' => 'The link to the content',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
          array(
            'key' => 'field_5d517a8d83608',
            'label' => 'Link name',
            'name' => 'link_name',
            'type' => 'text',
            'instructions' => 'The text to show in place of the link.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => 100,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:link',
            ),
          ),
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:link-fr',
            ),
          ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'modified' => 1579440624,
      ));

      acf_add_local_field_group(array(
        'key' => 'group_5d51efb2ca1cb',
        'title' => 'Book',
        'fields' => array(
          array(
            'key' => 'field_5d51efce06ad8',
            'label' => 'Editor',
            'name' => 'editor',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => 50,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:book',
            ),
          ),
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:book-fr',
            ),
          ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'modified' => 1579440642,
      ));

      acf_add_local_field_group(array(
        'key' => 'group_5d5196e8667aa',
        'title' => 'Youtube',
        'fields' => array(
          array(
            'key' => 'field_5d5196eb863b5',
            'label' => 'Youtube ID',
            'name' => 'youtube_id',
            'type' => 'text',
            'instructions' => 'The ID of this Youtube video',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => 11,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:yt-fr',
            ),
          ),
          array(
            array(
              'param' => 'post_taxonomy',
              'operator' => '==',
              'value' => 'res_types:yt',
            ),
          ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'modified' => 1579440650,
      ));

      endif;
  }
}
