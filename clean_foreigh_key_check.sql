delete from `catalog_category_product` WHERE product_id not in(select entity_id from catalog_product_entity);
delete from `catalog_category_product` WHERE category_id not in(select entity_id from catalog_category_entity) ;

delete from `catalog_product_index_eav_idx` WHERE entity_id not in(select entity_id from catalog_product_entity) ;

delete from `catalog_product_index_eav` WHERE entity_id not in(select entity_id from catalog_product_entity) ;

delete from `catalog_product_link` WHERE product_id not in(select entity_id from catalog_product_entity) ;

delete from `catalog_product_relation` WHERE parent_id not in(select entity_id from catalog_product_entity);
