# core (subsystem) Upgrade notes

## 4.5dev+

### Removed

- The previously deprecated function `search_generate_text_SQL` has been removed and can no longer be used.

  For more information see [MDL-48940](https://tracker.moodle.org/browse/MDL-48940)
- The previously deprecated function `core_text::reset_caches()` has been removed and can no longer be used.

  For more information see [MDL-71748](https://tracker.moodle.org/browse/MDL-71748)
- The following previously deprecated methods have been removed and can no longer be used:
    - `renderer_base::should_display_main_logo`

  For more information see [MDL-73165](https://tracker.moodle.org/browse/MDL-73165)
- Final deprecation of print_error(). Use moodle_exception instead.

  For more information see [MDL-74484](https://tracker.moodle.org/browse/MDL-74484)
- Final deprecation of \core\task\manager::ensure_adhoc_task_qos()

  For more information see [MDL-74843](https://tracker.moodle.org/browse/MDL-74843)
- Support for deprecated `<component>\local\views\secondary` block/activity namespace, for overriding secondary navigation, is now entirely removed

  For more information see [MDL-74939](https://tracker.moodle.org/browse/MDL-74939)
- Remove deprecation layer for YUI Events. The deprecation layer was introduced with MDL-70990 and MDL-72291.

  For more information see [MDL-77167](https://tracker.moodle.org/browse/MDL-77167)

### Deprecated

- The following method has been deprecated and should no longer be used: `reset_password_and_mail`. Please consider using `setnew_password_and_mail` as a replacement.

  For more information see [MDL-64148](https://tracker.moodle.org/browse/MDL-64148)
- - Final deprecation and removal of the following functions:
    - `plagiarism_plugin::get_configs()`
    - `plagiarism_plugin::get_file_results()`
    - `plagiarism_plugin::update_status()`, please use `{plugin name}_before_standard_top_of_body_html` instead.
  - Final deprecation and removal of `plagiarism_get_file_results()`. Please use `plagiarism_get_links()` instead. - Final deprecation and removal of `plagiarism_update_status()`. Please use `{plugin name}_before_standard_top_of_body_html()` instead.

  For more information see [MDL-71326](https://tracker.moodle.org/browse/MDL-71326)
- `moodle_list` and `list_item` were only used by `qbank_managecategories`, and these usages have been removed, so these classes (and thus all of listlib.php) are now deprecated. This method was the only usage of the `QUESTION_PAGE_LENGTH` constant, which was defined in `question_category_object.php`, and so is also now deprecated.

  For more information see [MDL-72397](https://tracker.moodle.org/browse/MDL-72397)
- The following methods have been deprecated, existing usage should switch to secure `\core\encryption` library:
  - `rc4encrypt`
  - `rc4decrypt`
  - `endecrypt`

  For more information see [MDL-81940](https://tracker.moodle.org/browse/MDL-81940)
- The following method has been deprecated and should not be used any longer: `print_grade_menu`.

  For more information see [MDL-82157](https://tracker.moodle.org/browse/MDL-82157)
- The following files and their contents have been deprecated:
  - `lib/soaplib.php`
  - `lib/tokeniserlib.php`

  For more information see [MDL-82191](https://tracker.moodle.org/browse/MDL-82191)
- The following methods have been formally deprecated:
  - `get_core_subsystems`
  - `get_plugin_types`
  - `get_plugin_list`
  - `get_plugin_list_with_class`
  - `get_plugin_directory`
  - `normalize_component`
  - `get_component_directory`
  - `get_context_instance`
  Note: These methods have been deprecated for a long time, but previously did not emit any deprecation notice.

  For more information see [MDL-82287](https://tracker.moodle.org/browse/MDL-82287)
- The following methods have been finally deprecated and will now throw an exception if called:
  - `get_context_instance`
  - `can_use_rotated_text`
  - `get_system_context`
  - `print_arrow`

  For more information see [MDL-82287](https://tracker.moodle.org/browse/MDL-82287)

### Added

- Add \core_user::get_name_placeholders() to return an array of user name fields.

  For more information see [MDL-64148](https://tracker.moodle.org/browse/MDL-64148)
- The following classes have been renamed and now support autoloading.
  Existing classes are currently unaffected.
  | Old class name | New class name |
  | --- | --- |
  | `\core_component` | `\core\component` |

  For more information see [MDL-66903](https://tracker.moodle.org/browse/MDL-66903)
- Added the ability for unit tests to autoload classes in the `\[component]\tests\`
  namespace from the `[path/to/component]/tests/classes` directory.

  For more information see [MDL-66903](https://tracker.moodle.org/browse/MDL-66903)
- Added a helper to load fixtures from a components `tests/fixtures/` folder:
  ```php
  advanced_testcase::load_fixture(string $component, string $fixture): void;
  ```

  For more information see [MDL-66903](https://tracker.moodle.org/browse/MDL-66903)
- Redis session cache has been improved to make a single call where two were used before.
   - The minimum Redis server version is now 2.6.12.
   - The minimum PHP Redis extension version is now 2.2.4.

  For more information see [MDL-69684](https://tracker.moodle.org/browse/MDL-69684)
- Added stored progress bars

  For more information see [MDL-70854](https://tracker.moodle.org/browse/MDL-70854)
- Two new functions have been introduced in the \moodle_database class:
  - `get_counted_records_sql()`
  - `get_counted_recordset_sql()`
  These methods are compatible with all databases.
  They will check the current running database engine and apply the COUNT window function if it is supported,
  otherwise, they will use the usual COUNT function.
  The COUNT window function optimization is applied to the following databases:
  - PostgreSQL
  - MariaDB
  - Oracle
  MySQL and SQL Server do not use this optimization due to insignificant performance differences before and
  after the improvement.

  For more information see [MDL-78030](https://tracker.moodle.org/browse/MDL-78030)
- The `after_config()` callback has been converted to a hook, `\core\hook\after_config`.

  For more information see [MDL-79011](https://tracker.moodle.org/browse/MDL-79011)
- The core\output\select_menu widget now supports rendering dividers between menu options. Empty elements (null or empty strings) within the array of options are considered and rendered as dividers in the dropdown menu.

  For more information see [MDL-80747](https://tracker.moodle.org/browse/MDL-80747)
- The `core\output\select_menu` widget now supports a new feature: inline labels. You can render the label inside the combobox widget by passing `true` to the `$inlinelabel` parameter when calling the `->set_label()` method.

  For more information see [MDL-80747](https://tracker.moodle.org/browse/MDL-80747)
- The following classes have been renamed.
  Existing classes are currently unaffected.
  | Old class name | New class name |
  | --- | --- |
  | `\core_user` | `\core\user` |

  For more information see [MDL-81031](https://tracker.moodle.org/browse/MDL-81031)
- New DML constant `SQL_INT_MAX` to define the size of a large integer with cross database platform support

  For more information see [MDL-81282](https://tracker.moodle.org/browse/MDL-81282)
- The function update_display_mode will update the eye icon (enabled/disabled) in the availability. The $pluginname is represented to the plugin need to update. The $displaymode is represented to the eye icon. Whether it enabled or disabled.

  For more information see [MDL-81533](https://tracker.moodle.org/browse/MDL-81533)
- Added an `exception` L2 Namespace to APIs

  For more information see [MDL-81903](https://tracker.moodle.org/browse/MDL-81903)
- Added a mechanism to support autoloading of legacy class files.
  This will help to reduce the number of require_once calls in the codebase, and move away from the use of monolithic libraries.

  For more information see [MDL-81919](https://tracker.moodle.org/browse/MDL-81919)
- The following exceptions are now also available in the `\core\exception` namespace:
    - `\coding_exception`
    - `\file_serving_exception`
    - `\invalid_dataroot_permissions`
    - `\invalid_parameter_exception`
    - `\invalid_response_exception`
    - `\invalid_state_exception`
    - `\moodle_exception`
    - `\require_login_exception`
    - `\require_login_session_timeout_exception`
    - `\required_capability_exception`
    - `\webservice_parameter_exception`

  For more information see [MDL-81919](https://tracker.moodle.org/browse/MDL-81919)
- The following classes have been moved into the `\core` namespace and now support autoloading:
  - `emoticon_manager`
  - `lang_string`

  For more information see [MDL-81920](https://tracker.moodle.org/browse/MDL-81920)
- The following classes have been renamed and now support autoloading. Existing classes are currently unaffected.
  | Old class name | New class name |
  | --- | --- |
  | `\moodle_url` | `\core\url` |
  | `\progress_trace` | `\core\output\progress_trace` |
  | `\combined_progress_trace` | `\core\output\progress_trace\combined_progress_trace` |
  | `\error_log_progress_trace` | `\core\output\progress_trace\error_log_progress_trace` |
  | `\html_list_progress_trace` | `\core\output\progress_trace\html_list_progress_trace` |
  | `\html_progress_trace` | `\core\output\progress_trace\html_progress_trace` |
  | `\null_progress_trace` | `\core\output\progress_trace\null_progress_trace` |
  | `\progress_trace_buffer` | `\core\output\progress_trace\progress_trace_buffer` |
  | `\text_progress_trace` | `\core\output\progress_trace\text_progress_trace` |

  For more information see [MDL-81960](https://tracker.moodle.org/browse/MDL-81960)
- The following classes are now also available in the following new locations. They will continue to work in their old locations:
  | Old classname | New classname |
  | --- | --- |
  | `\action_link` | `\core\output\action_link` |
  | `\action_menu_filler` | `\core\output\action_menu\filler` |
  | `\action_menu_link_primary` | `\core\output\action_menu\link_primary` |
  | `\action_menu_link_secondary` | `\core\output\action_menu\link_secondary` |
  | `\action_menu_link` | `\core\output\action_menu\link` |
  | `\action_menu` | `\core\output\action_menu` |
  | `\block_contents` | `\core_block\output\block_contents` |
  | `\block_move_target` | `\core_block\output\block_move_target` |
  | `\component_action` | `\core\output\actions\component_action` |
  | `\confirm_action` | `\core\output\actions\confirm_action` |
  | `\context_header` | `\core\output\context_header` |
  | `\core\output\local\action_menu\subpanel` | `\core\output\action_menu\subpanel` |
  | `\core_renderer_ajax` | `\core\output\core_renderer_ajax` |
  | `\core_renderer_cli` | `\core\output\core_renderer_cli` |
  | `\core_renderer_maintenance` | `\core\output\core_renderer_maintenance` |
  | `\core_renderer` | `\core\output\core_renderer` |
  | `\custom_menu_item` | `\core\output\custom_menu_item` |
  | `\custom_menu` | `\core\output\custom_menu` |
  | `\file_picker` | `\core\output\file_picker` |
  | `\flexible_table` | `\core_table\flexible_table` |
  | `\fragment_requirements_manager` | `\core\output\requirements\fragment_requirements_manager` |
  | `\help_icon` | `\core\output\help_icon` |
  | `\html_table_cell` | `\core_table\output\html_table_cell` |
  | `\html_table_row` | `\core_table\output\html_table_row` |
  | `\html_table` | `\core_table\output\html_table` |
  | `\html_writer` | `\core\output\html_writer` |
  | `\image_icon` | `\core\output\image_icon` |
  | `\initials_bar` | `\core\output\initials_bar` |
  | `\js_writer` | `\core\output\js_writer` |
  | `\page_requirements_manager` | `\core\output\requirements\page_requirements_manager` |
  | `\paging_bar` | `\core\output\paging_bar` |
  | `\pix_emoticon` | `\core\output\pix_emoticon` |
  | `\pix_icon_font` | `\core\output\pix_icon_font` |
  | `\pix_icon_fontawesome` | `\core\output\pix_icon_fontawesome` |
  | `\pix_icon` | `\core\output\pix_icon` |
  | `\plugin_renderer_base` | `\core\output\plugin_renderer_base` |
  | `\popup_action` | `\core\output\actions\popup_action` |
  | `\preferences_group` | `\core\output\preferences_group` |
  | `\preferences_groups` | `\core\output\preferences_groups` |
  | `\progress_bar` | `\core\output\progress_bar` |
  | `\renderable` | `\core\output\renderable` |
  | `\renderer_base` | `\core\output\renderer_base` |
  | `\renderer_factory_base` | `\core\output\renderer_factory\renderer_factory_base` |
  | `\renderer_factory` | `\core\output\renderer_factory\renderer_factory_interface` |
  | `\single_button` | `\core\output\single_button` |
  | `\single_select` | `\core\output\single_select` |
  | `\standard_renderer_factory` | `\core\output\renderer_factory\standard_renderer_factory` |
  | `\table_dataformat_export_format` | `\core_table\dataformat_export_format` |
  | `\table_default_export_format_parent` | `\core_table\base_export_format` |
  | `\table_sql` | `\core_table\sql_table` |
  | `\tabobject` | `\core\output\tabobject` |
  | `\tabtree` | `\core\output\tabtree` |
  | `\templatable` | `\core\output\templatable` |
  | `\theme_config` | `\core\output\theme_config` |
  | `\theme_overridden_renderer_factory` | `\core\output\renderer_factory\theme_overridden_renderer_factory` |
  | `\url_select` | `\core\output\url_select` |
  | `\user_picture` | `\core\output\user_picture` |
  | `\xhtml_container_stack` | `\core\output\xhtml_container_stack` |
  | `\YUI_config` | `\core\output\requirements\yui` |

  For more information see [MDL-82183](https://tracker.moodle.org/browse/MDL-82183)
- A new method, get_deprecated_icons(), has been added to the icon_system class. All deprecated icons should be registered through this method. Plugins can implement a callback to pluginname_get_deprecated_icons() to register their deprecated icons too. When $CFG->debugpageinfo is enabled, a console message will display a list of the deprecated icons.

  For more information see [MDL-82212](https://tracker.moodle.org/browse/MDL-82212)
- Add optional icon and title to notification. Two parameters have been added to the `core\output\notification` so when creating a notification you can pass an icon and a title.

  For more information see [MDL-82297](https://tracker.moodle.org/browse/MDL-82297)
- The Moodle autoloader should now be registered using `\core\component::register_autoloader` rather than manually doing so in any exceptional location which requires it. It is not normally necessary to include the autoloader manually, as it is registered automatically when the Moodle environment is bootstrapped.

  For more information see [MDL-82747](https://tracker.moodle.org/browse/MDL-82747)
- A new JS module for interacting with the Routed REST API has been introduced.
  For more information see the documentation in the `core/fetch` module.

  For more information see [MDL-82778](https://tracker.moodle.org/browse/MDL-82778)

### Changed

- The class autoloader has been moved to an earlier point in the Moodle bootstrap.
  Autoloaded classes are now available to scripts using the `ABORT_AFTER_CONFIG` constant.

  For more information see [MDL-80275](https://tracker.moodle.org/browse/MDL-80275)
- The `\core\dataformat::get_format_instance` method is now public, and can be used to retrieve a writer instance for a given dataformat

  For more information see [MDL-81781](https://tracker.moodle.org/browse/MDL-81781)
- The `get_home_page()` method can now return new constant `HOMEPAGE_URL`, applicable when a third-party hook has extended the default homepage options for the site
  A new method, `get_default_home_page_url()` has been added which will return the correct URL when this constant is returned

  For more information see [MDL-82066](https://tracker.moodle.org/browse/MDL-82066)

### Fixed

- All the setup and tear down methods of `PHPUnit` now are required to, always, call to their parent counterparts. This is a good practice to avoid future problems, especially when updating to PHPUnit >= 10.
  This includes the following methods:
    - `setUp()`
    - `tearDown()`
    - `setUpBeforeClass()`
    - `tearDownAfterClass()`

  For more information see [MDL-81523](https://tracker.moodle.org/browse/MDL-81523)
- Use server timezone when constructing `\DateTimeImmutable` for the system `\core\clock` implementation.

  For more information see [MDL-81894](https://tracker.moodle.org/browse/MDL-81894)
