<?php

namespace Oro\Bundle\NavigationBundle\Validator\Constraints;

use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Oro\Bundle\NavigationBundle\Entity\MenuUpdateInterface;
use Oro\Bundle\NavigationBundle\Provider\BuilderChainProvider;
use Oro\Bundle\NavigationBundle\Utils\MenuUpdateUtils;

use Knp\Menu\ItemInterface;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxNestedLevelValidator extends ConstraintValidator
{
    /** @var BuilderChainProvider */
    private $builderChainProvider;

    /** @var LocalizationHelper */
    private $localizationHelper;

    /**
     * @param BuilderChainProvider $builderChainProvider
     * @param LocalizationHelper $localizationHelper
     */
    public function __construct(BuilderChainProvider $builderChainProvider, LocalizationHelper $localizationHelper)
    {
        $this->builderChainProvider = $builderChainProvider;
        $this->localizationHelper = $localizationHelper;
    }

    /**
     * {@inheritdoc}
     *
     * @param MenuUpdateInterface $entity
     */
    public function validate($entity, Constraint $constraint)
    {
        $options = [
            'ignoreCache' => true,
            'ownershipType' => $entity->getOwnershipType()
        ];

        $menu = $this->builderChainProvider->get($entity->getMenu(), $options);

        $itemExist = MenuUpdateUtils::findMenuItem($menu, $entity->getKey()) ? true : false;

        MenuUpdateUtils::updateMenuItem($entity, $menu, $this->localizationHelper);

        /** @var ItemInterface $item */
        foreach ($menu->getChildren() as $item) {
            $item = MenuUpdateUtils::getItemExceededMaxNestingLevel($menu, $item);
            if ($item) {
                $this->context->addViolation(
                    sprintf("Item \"%s\" can't be saved. Max nesting level is reached.", $item->getLabel())
                );

                if (!$itemExist) {
                    $item->getParent()->removeChild($item->getName());
                }

                break;
            }
        }
    }
}