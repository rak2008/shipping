(function ($, Drupal, drupalSettings) {
  'use strict';
  var INNOVATION = INNOVATION || {};
  INNOVATION.currentRegion = null;
  INNOVATION.currentLayout = null;
  INNOVATION.currentLayoutIndex = null;
  INNOVATION.currentPreset = null;
  INNOVATION.currentSection = null;
  INNOVATION.base64Encode = function (c) {
    var keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var a = "";
    var k, h, f, j, g, e, d;
    var b = 0;
    c = INNOVATION.UTF8Encode(c);
    while (b < c.length) {
      k = c.charCodeAt(b++);
      h = c.charCodeAt(b++);
      f = c.charCodeAt(b++);
      j = k >> 2;
      g = ((k & 3) << 4) | (h >> 4);
      e = ((h & 15) << 2) | (f >> 6);
      d = f & 63;
      if (isNaN(h)) {
        e = d = 64
      } else {
        if (isNaN(f)) {
          d = 64
        }
      }
      a = a + keyString.charAt(j) + keyString.charAt(g) + keyString.charAt(e) + keyString.charAt(d)
    }
    return a;
  };
  INNOVATION.UTF8Encode = function (b) {
    b = b.replace(/\x0d\x0a/g, "\x0a");
    var a = "";
    for (var e = 0; e < b.length; e++) {
      var d = b.charCodeAt(e);
      if (d < 128) {
        a += String.fromCharCode(d)
      } else {
        if ((d > 127) && (d < 2048)) {
          a += String.fromCharCode((d >> 6) | 192);
          a += String.fromCharCode((d & 63) | 128)
        } else {
          a += String.fromCharCode((d >> 12) | 224);
          a += String.fromCharCode(((d >> 6) & 63) | 128);
          a += String.fromCharCode((d & 63) | 128)
        }
      }
    }
    return a;
  };
  INNOVATION.keyGen = function (title) {
    return title.replace(/[^a-z0-9]/g, function (s) {
      var c = s.charCodeAt(0);
      if (c == 32)
        return '-';
      if (c >= 65 && c <= 90)
        return s.toLowerCase();
      return '__' + ('000' + c.toString(16)).slice(-4);
    });
  };
  INNOVATION.draw = function (layout) {
    $('ul#inv_sections').html('');
    $(layout.sections).each(function () {
      this.regions == this.regions || [];
      var section = $('<li>');
      section.data({
        backgroundcolor: this.backgroundcolor || '',
        colpadding: this.colpadding || '',
        custom_class: this.custom_class || '',
        fullwidth: this.fullwidth || 'no',
        hdesktop: this.hdesktop || false,
        hphone: this.hphone || false,
        htablet: this.htablet || false,
        key: this.key || "",
        sticky: this.sticky || false,
        title: this.title || "",
        vdesktop: this.vdesktop || false,
        vphone: this.vphone || false,
        vtablet: this.vtablet || false,
        weight: this.weight || 0,
      });
      section.css({
        backgroundColor: this.backgroundcolor
      });
      section.addClass('inv-section');

      if (this.key == 'unassigned') {
        section.addClass('inv-section-unassigned');
      }
      var sectionHeader = $('<div class="inv-section-header">');
      sectionHeader.append('<i class="fa fa-arrows section-sortable"></i>');
      sectionHeader.append('<span class="section_title">' + this.title + '</span>');
      sectionHeader.append('<i class="fa fa-gears section-settings pull-right"></i>');
      section.append(sectionHeader);
      section.append('<ul class="inv-section-inner row"></ul>');
      $('ul#inv_sections').append(section);
      $('ul#inv_sections').sortable({
        handle: '.section-sortable',
        cancel: '.inv-section-unassigned',
      });
      $(this.regions).each(function () {
        var region = $('<li>');
        region.addClass('inv-region');
        this.collg = this.collg || 6;
        this.colmd = this.colmd || 6;
        this.colsm = this.colsm || 12;
        this.colxs = this.colxs || 12;
        this.collgoffset = this.collgoffset || 0;
        this.colmdoffset = this.colmdoffset || 0;
        this.colsmoffset = this.colsmoffset || 0;
        this.colxsoffset = this.colxsoffset || 0;
        region.data({
          collg: this.collg,
          colmd: this.colmd,
          colsm: this.colsm,
          colxs: this.colxs,
          collgoffset: this.collgoffset,
          colmdoffset: this.colmdoffset,
          colsmoffset: this.colsmoffset,
          colxsoffset: this.colxsoffset,
          custom_class: this.custom_class || '',
          key: this.key || '',
          title: this.title || '',
          weight: this.weight || 0
        });
        region.append('<div class="region-inner"><i class="fa fa-arrows region-sortable"></i>' + this.title + '<i class="fa fa-gears region-settings pull-right"></i></div>');
        region.addClass('col-lg-' + this.collg);
        region.addClass('col-md-' + this.colmd);
        region.addClass('col-sm-' + this.colsm);
        region.addClass('col-xs-' + this.colxs);
        region.addClass('col-lg-offset-' + this.collgoffset);
        region.addClass('col-md-offset-' + this.colmdoffset);
        region.addClass('col-sm-offset-' + this.colsmoffset);
        region.addClass('col-xs-offset-' + this.colxsoffset);
        section.find('.inv-section-inner').append(region);
      });
      $('.inv-section-inner').sortable({
        handle: '.region-sortable',
        connectWith: '.inv-section-inner'
      });
    });
    Drupal.attachBehaviors(document.getElementById('inv_sections'));
  }

  INNOVATION.saveLayout = function () {
    if (INNOVATION.currentLayoutIndex == null)
      return false;
    drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].sections = [];
    $('.inv-section').each(function (index) {
      var section = {
        backgroundcolor: $(this).data('backgroundcolor'),
        colpadding: $(this).data('colpadding'),
        custom_class: $(this).data('custom_class'),
        fullwidth: $(this).data('fullwidth'),
        hdesktop: $(this).data('hdesktop'),
        hphone: $(this).data('hphone'),
        htablet: $(this).data('htablet'),
        key: $(this).data('key'),
        sticky: $(this).data('sticky'),
        title: $(this).data('title'),
        vdesktop: $(this).data('vdesktop'),
        vphone: $(this).data('vphone'),
        vtablet: $(this).data('vtablet'),
        weight: index,
        regions: [],
      };
      $($(this).find('.inv-region')).each(function (index) {
        var region = {
          collg: $(this).data('collg'),
          colmd: $(this).data('colmd'),
          colsm: $(this).data('colsm'),
          colxs: $(this).data('colxs'),
          collgoffset: $(this).data('collgoffset'),
          colmdoffset: $(this).data('colmdoffset'),
          colsmoffset: $(this).data('colsmoffset'),
          colxsoffset: $(this).data('colxsoffset'),
          custom_class: $(this).data('custom_class'),
          key: $(this).data('key'),
          title: $(this).data('title'),
          weight: index
        };
        section.regions.push(region);
      });
      drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].sections.push(section);
    });
  }

  INNOVATION.setFormVal = function (context, element) {
    $('[data-key]', context).each(function () {
      if ($(this).is('[type=checkbox]')) {
        $(this).attr('checked', $(element).data($(this).data('key')));
      } else {
        $(this).val($(element).data($(this).data('key')));
      }
    });
  };

  INNOVATION.saveFormVal = function (context, element) {
    $('[data-key]', context).each(function () {
      if ($(this).is('[type=checkbox]')) {
        $(element).data($(this).data('key'), $(this).is(':checked'));
      } else {
        $(element).data($(this).data('key'), $(this).val());
      }
    });
  };

  /*Layout settings*/
  Drupal.behaviors.innovation_init = {
    attach: function (context, settings) {
      $('ul#inv_layouts', context).find('li').remove();
      $(settings.innovation.layouts).each(function (index) {
        var tab = $('<li class="inv_layout">');
        tab.data({
          title: this.title,
          key: this.key,
          pages: this.pages,
          isdefault: this.isdefault
        });
        var defaultText = "";
        if (this.isdefault) {
          defaultText = '<span style="color:#ff0000">*</span>';
        }
        tab.append('<a href="#" class="layout-title">' + this.title + defaultText + '</a>');
        tab.append('<span class="fa fa-gears layout-settings"></span>');
        tab.find('.layout-title').on('click', function () {
          //$(this).click(function () {
          INNOVATION.saveLayout();
          INNOVATION.currentLayoutIndex = index;
          $('.inv_layout').removeClass('active');
          $(this).closest('.inv_layout').addClass('active');
          INNOVATION.draw(drupalSettings.innovation.layouts[index]);
          return false;
          //});
        });
        $('ul#inv_layouts', context).append(tab);
      });
    }
  }

  Drupal.behaviors.innovation_layout_settings = {
    attach: function (context, settings) {
      $('#edit-innovation-layouts-edit').dialog({
        autoOpen: false,
        title: Drupal.t('Layout settings'),
        width: '60%',
        height: 400,
        modal: true,
        open: function () {
          var layout = settings.innovation.layouts[INNOVATION.currentLayoutIndex];
          $('[name=layout_name]').val(layout.title);
          $('[name=layout_default]').attr('checked', layout.isdefault);
          $('[name=inv_layout_pages]').val(layout.pages);
          if (layout.isdefault) {
            $('[name=inv_layout_pages]').closest('.form-item').hide();
          } else {
            $('[name=inv_layout_pages]').closest('.form-item').show();
          }
        },
        buttons: [
          {
            text: Drupal.t('Save'),
            click: function () {
              drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].title = $('[name=layout_name]').val();
              drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].key = INNOVATION.keyGen($('[name=layout_name]').val());
              drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].pages = $('[name=inv_layout_pages]').val();
              drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].isdefault = $('[name=layout_default]').is(':checked');
              if (drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex].isdefault) {
                $(drupalSettings.innovation.layouts).each(function (index) {
                  if (index != INNOVATION.currentLayoutIndex) {
                    drupalSettings.innovation.layouts[index].isdefault = false;
                  }
                });
              } else {
                var hasdefault = false;
                $(drupalSettings.innovation.layouts).each(function (index) {
                  if (drupalSettings.innovation.layouts[index].isdefault) {
                    hasdefault = drupalSettings.innovation.layouts[index].isdefault;
                  }
                });
                if (!hasdefault)
                  drupalSettings.innovation.layouts[0].isdefault = true;
              }
              Drupal.attachBehaviors();
              $('ul#inv_layouts li:eq(' + INNOVATION.currentLayoutIndex + ') .layout-title').trigger('click');
              $(this).dialog('close');
            }
          },
          {
            text: Drupal.t('Clone layout'),
            click: function () {
              INNOVATION.saveLayout(drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex]);
              var newLayout = {};
              $.extend(true, newLayout, drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex]);
              newLayout.title = 'copy of ' + newLayout.title;
              newLayout.isdefault = false;
              newLayout.pages = '';
              drupalSettings.innovation.layouts.push(newLayout);
              Drupal.attachBehaviors();
              $('ul#inv_layouts li:last .layout-title').trigger('click');
              $(this).dialog('close');
            }
          },
          {
            text: Drupal.t('Remove layout'),
            click: function () {
              if (settings.innovation.layouts.length == 1) {
                alert(Drupal.t('Can not remove this layout'));
              } else if (confirm(Drupal.t('Are you sure you want to remove this layout?'))) {
                drupalSettings.innovation.layouts.splice(INNOVATION.currentLayoutIndex, 1);
                INNOVATION.currentLayoutIndex = null;
                Drupal.attachBehaviors();
                $('ul#inv_layouts li:first .layout-title').trigger('click');
                $(this).dialog('close');
              }
            }
          },
          {
            text: Drupal.t('Cancel'),
            click: function () {
              $(this).dialog('close');
            }
          }
        ]
      });
      $('.layout-settings', context).once('click').on('click', function () {
        INNOVATION.currentLayout = $(this).closest('.inv_layout');
        $('#edit-innovation-layouts-edit').dialog('open');
      });
    }
  }

  Drupal.behaviors.innovation_section_settings = {
    attach: function (context, settings) {
      $('#edit-innovation-section-settings', context).dialog({
        autoOpen: false,
        title: Drupal.t('Section settings'),
        width: '60%',
        height: 500,
        modal: true,
        open: function (event, ui) {
          INNOVATION.setFormVal('#edit-innovation-section-settings', INNOVATION.currentSection);
        },
        buttons: [
          {
            text: Drupal.t('Save'),
            click: function () {
              INNOVATION.saveFormVal('#edit-innovation-section-settings', INNOVATION.currentSection);
              INNOVATION.currentSection.find('.section_title').text(INNOVATION.currentSection.data('title'));
              INNOVATION.saveLayout(settings.innovation.layouts[INNOVATION.currentLayoutIndex]);
              INNOVATION.draw(settings.innovation.layouts[INNOVATION.currentLayoutIndex]);
              $(this).dialog('close');
            }
            }, {
            text: Drupal.t('Remove section'),
            click: function () {
              if (confirm(Drupal.t('Are you sure you want to remove this section?'))) {
                INNOVATION.currentSection.find('.inv-region').each(function () {
                  $('.inv-section-unassigned ul').append($(this));
                });
                INNOVATION.currentSection.remove();
                INNOVATION.saveLayout(drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex]);
                $(this).dialog('close');
              }
            }
            }
          ]
      });

      $('.section-settings').once('click').on('click', function () {
        INNOVATION.currentSection = $(this).closest('.inv-section');
        $('#edit-innovation-section-settings').dialog('open');
      });
    }
  }

  Drupal.behaviors.innovation_region_settings = {
    attach: function (context, settings) {
      $('#edit-innovation-region-settings', context).dialog({
        autoOpen: false,
        title: Drupal.t('Region settings'),
        width: '70%',
        height: 400,
        modal: true,
        open: function (event, ui) {
          INNOVATION.setFormVal('#edit-innovation-region-settings', INNOVATION.currentRegion);
        },
        buttons: [
          {
            text: Drupal.t('Save'),
            click: function () {
              INNOVATION.saveFormVal('#edit-innovation-region-settings', INNOVATION.currentRegion);
              INNOVATION.currentRegion.attr('class', '');
              INNOVATION.currentRegion.addClass('inv-region');
              INNOVATION.currentRegion.addClass('col-lg-' + $('[name=region_col_lg]').val());
              INNOVATION.currentRegion.addClass('col-md-' + $('[name=region_col_md]').val());
              INNOVATION.currentRegion.addClass('col-sm-' + $('[name=region_col_sm]').val());
              INNOVATION.currentRegion.addClass('col-xs-' + $('[name=region_col_xs]').val());
              $(this).dialog('close');
            }
            },
          {
            text: Drupal.t('Cancel'),
            click: function () {
              $(this).dialog('close');
            }
            }
          ]
      });
      //});
      $('.region-settings').on('click', function () {
        INNOVATION.currentRegion = $(this).closest('.inv-region');
        $('#edit-innovation-region-settings').dialog('open');
      });
    }
  }

  Drupal.behaviors.innovation_add_section = {
    attach: function (context, settings) {
      $('body').once('section-settings').append('<div id="innovation_add_section_dialog" title="Add section">Section: <input type="text" class="form-text" name="section_name"/></div>');
      $('#innovation_add_section_dialog').dialog({
        autoOpen: false,
        modal: true,
        width: 300,
        height: 200,
        buttons: [
          {
            text: Drupal.t('Save'),
            click: function () {
              if ($('[name=section_name]').val().trim() != '') {
                var newSection = {
                  title: $('[name=section_name]').val().trim(),
                  key: INNOVATION.keyGen($('[name=section_name]').val().trim()),
                  regions: []
                };
                settings.innovation.layouts[INNOVATION.currentLayoutIndex].sections.splice(settings.innovation.layouts[INNOVATION.currentLayoutIndex].sections.length - 1, 0, newSection);
                INNOVATION.draw(settings.innovation.layouts[INNOVATION.currentLayoutIndex]);
              }
              $(this).dialog('close');
            }
          }
        ]
      });
      $('#innovation_add_section a').on('click', function () {
        $('#innovation_add_section_dialog').dialog('open');
        return false;
      });
    }
  }

  Drupal.behaviors.innovation_add_layout = {
    attach: function () {
      $('.inv-add-layout').once('click').on('click', function () {
        //$(this).click(function () {
        INNOVATION.saveLayout(drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex]);
        var newLayout = {
          title: Drupal.t('New Layout'),
          key: INNOVATION.keyGen(Drupal.t('New Layout'))
        };
        var unassigned_section = {
          key: 'unassigned',
          title: Drupal.t('Unassigned'),
          regions: []
        };
        $(drupalSettings.innovation.layouts[0].sections).each(function () {
          $(this.regions).each(function () {
            var region = {};
            $.extend(true, region, this);
            unassigned_section.regions.push(region);
          });
        });
        newLayout.sections = [unassigned_section];
        drupalSettings.innovation.layouts.push(newLayout);
        Drupal.attachBehaviors();
        $('ul#inv_layouts li:last .layout-title').trigger('click');
        //});
        return false;
      });
    }
  }

  /*Preset settings*/

  Drupal.behaviors.innovation_presets = {
    attach: function (context, settings) {
      var presets = settings.innovation_presets;
      var farb = $.farbtastic('#placeholder');
      $('#edit-innovation-presets-list').once()
      $('#edit-innovation-presets-list').once('change').each(function () {
        INNOVATION.currentPreset = $(this).val();
        $(this).change(function(){
          $('.preset-option').change(function () {
            drupalSettings.innovation_presets[INNOVATION.currentPreset][$(this).data('property')] = $(this).val();
          });
          INNOVATION.currentPreset = $(this).val();
          $('#edit-innovation-preset-key').val(settings.innovation_presets[INNOVATION.currentPreset].key);
          $('#edit-innovation-base-color').val(settings.innovation_presets[INNOVATION.currentPreset].base_color);
          $('#edit-innovation-base-color-opposite').val(settings.innovation_presets[INNOVATION.currentPreset].base_color_opposite || settings.innovation_presets[INNOVATION.currentPreset].base_color);
          $('#edit-innovation-link-color').val(settings.innovation_presets[INNOVATION.currentPreset].link_color);
          $('#edit-innovation-link-hover-color').val(settings.innovation_presets[INNOVATION.currentPreset].link_hover_color);
          $('#edit-innovation-text-color').val(settings.innovation_presets[INNOVATION.currentPreset].text_color);
          $('#edit-innovation-heading-color').val(settings.innovation_presets[INNOVATION.currentPreset].heading_color);
          $('.color').each(function () {
            farb.linkTo(this);
          });
        }).trigger('change');
      });

      $('.color').focus(function () {
        $('#edit-preset-settings .form-item').removeClass('focus');
        $(this).parents('.form-item').addClass('focus');
        farb.linkTo(this);
      });
    }
  }

  Drupal.behaviors.innovation_form_submit = {
    attach: function () {
      $('form#system-theme-settings').once('innovation-submit').submit(function () {
          INNOVATION.saveLayout(drupalSettings.innovation.layouts[INNOVATION.currentLayoutIndex]);
          var layoutstr = INNOVATION.base64Encode(JSON.stringify(drupalSettings.innovation.layouts));
          var layoutstrs = layoutstr.match(/.{1,10000}/g);
          for (var i = 0; i < layoutstrs.length; i++) {
            $('[name=inv_layout_'+i+']').val(layoutstrs[i]);
          }
          console.log(drupalSettings.innovation.layouts);
          $('input[name=innovation_layouts]').val(layoutstr);
          

          $('.preset-option').each(function () {
            drupalSettings.innovation_presets[INNOVATION.currentPreset][$(this).data('property')] = $(this).val();
          });
          $('input[name=innovation_presets]').val(INNOVATION.base64Encode(JSON.stringify(drupalSettings.innovation_presets)));

          return true;
      });
    }
  }

  Drupal.behaviors.innovation_google_font = {
    attach: function (context, settings) {
      $('.google-font').once('google-font').each(function () {
        var $this = $(this);
        var font = $this.val().split(':');
        font[1] = font[1] || '';
        font[2] = font[2] || '13px';
        font[3] = font[3] || '';
        font[4] = font[4] || '';
        var $font = $('<fieldset class="form-wrapper"><div class="col-sm-6"><label>Font family</label><input type="text" name="family" class="form-text" value="' + font[0] + '"/></div><div class="col-sm-2"><label>Font Weight & Style</label><select name="style" class="form-select"></select></div><div class="col-sm-2"><label>Font Size (px/pt)</label><input name="size" value="' + font[2] + '" class="form-text"/></div><div class="col-sm-2"><label>Line height</label><input name="height" value="' + font[3] + '" class="form-text"/></div></fieldset>');
        var $family = $('[name=family]', $font);
        var $style = $('[name=style]', $font);
        var $size = $('[name=size]', $font);
        var $height = $('[name=height]', $font);
        var $selector = null;
        if ($this.hasClass('custom-font')) {
          $font.append('<div class="col-sm-12"><label>Selector (add html tags ID or class (body,a,.class,#id))</label><input type="text" name="selector" value="' + font[4] + '" class="form-text"/></div>');
          $selector = $('[name=selector]', $font);
        }
        if (font[0] != '') {
          var font_selected = $.grep(drupalSettings.google_fonts.items, function (e) {
            return e.value == font[0];
          });
          if (font_selected.length > 0) {
            $(font_selected[0].variants).each(function (index, el) {
              $style.append(new Option(el, el));
            });
            $style.val(font[1]);
          }
        } else {
          $style.append(new Option(400, 400));
        }
        $(this).after($font);
        $style.change(function () {
          $this.val($family.val() + ':' + $style.val() + ':' + $size.val() + ':' + $height.val());
        });
        $family.autocomplete({
          source: drupalSettings.google_fonts.items,
          minLength: 3,
          select: function (event, ui) {
            $style.find('option').remove();
            $(ui.item.variants).each(function (index, el) {
              $style.append(new Option(el, el));
            });
            $this.val(ui.item.value + ':' + $style.val() + ':' + $size.val() + ':' + $height.val());
          }
        });
        setInterval(function () {
          if ($selector != null) {
            $this.val($family.val() + ':' + $style.val() + ':' + $size.val() + ':' + $height.val() + ':' + $selector.val());
          } else {
            $this.val($family.val() + ':' + $style.val() + ':' + $size.val() + ':' + $height.val());
          }
        }, 500);
      })
    }
  }

  $(document).ready(function () {
    $('ul#inv_layouts li:eq(0) .layout-title').trigger('click');
  });
})(jQuery, Drupal, drupalSettings);