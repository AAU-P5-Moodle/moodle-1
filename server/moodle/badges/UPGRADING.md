# core_badges (subsystem) Upgrade notes

## 4.5dev+

### Deprecated

- The badges/newbadge.php page has been deprecated and merged with badges/edit.php. Please, use badges/edit.php instead.

  For more information see [MDL-43938](https://tracker.moodle.org/browse/MDL-43938)
- OPEN_BADGES_V1 is deprecated and should not be used anymore.

  For more information see [MDL-70983](https://tracker.moodle.org/browse/MDL-70983)

### Removed

- Final removal of BADGE_BACKPACKAPIURL and BADGE_BACKPACKWEBURL.

  For more information see [MDL-70983](https://tracker.moodle.org/browse/MDL-70983)

### Added

- New webservices enable_badges and disable_badges have been added.

  For more information see [MDL-82168](https://tracker.moodle.org/browse/MDL-82168)

### Changed

- Added fields `recipientid` and `recipientfullname` to `user_badge_exporter`, which is used in the return structure of external functions `core_badges_get_user_badge_by_hash` and `core_badges_get_user_badges`.

  For more information see [MDL-82742](https://tracker.moodle.org/browse/MDL-82742)
