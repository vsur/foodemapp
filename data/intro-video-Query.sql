# Delete Burger (ID 23) binary component from DOM – Kitchen Grill (ID 884) and Zwiebel (ID 559)
# Necessary for Intro Video

DELETE FROM `binary_components_ypois` WHERE `binary_components_ypois`.`binary_component_id` = 23 AND `binary_components_ypois`.`ypoi_id` = 884;
DELETE FROM `binary_components_ypois` WHERE `binary_components_ypois`.`binary_component_id` = 23 AND `binary_components_ypois`.`ypoi_id` = 559;


# After makting the intro video one must restore the burger components for DOM – Kitchen Grill and Zwiebel 
# This is necessary for correct task evaluation later

INSERT INTO `binary_components_ypois` (`id`, `binary_component_id`, `ypoi_id`, `created`, `modified`) 
VALUES (NULL, '23', '884', NOW(), NOW()), (NULL, '23', '559', NOW(), NOW());