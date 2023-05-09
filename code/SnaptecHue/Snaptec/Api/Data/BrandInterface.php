<?php
namespace SnaptecHue\Snaptec\Api\Data;

interface BrandInterface
{
    const ENTITY_ID     = 'brand_id';
    const TITLE          = 'title';
    const DESCRIPTION   = 'description';
    const IMAGE          = 'image';
    const IS_ACTIVE    = 'is_active';
    const SORT_ORDER = 'sort_order';

    public function getId();

    public function setId($id);

    public function getTitle();

    public function setTitle($title);

    public function getDescription();

    public function setDescription($description);

    public function getImage();

    public function setImage($image);
    
    public function getIsActive();

    public function setIsActive($isActive);

    public function getSortOrder();

    public function setSortOrder($sortOrder);
}