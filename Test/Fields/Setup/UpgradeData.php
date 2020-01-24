<?php
namespace Test\Fields\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
	private $eavSetupFactory;
	
    private $eavConfig;

	public function __construct(EavSetupFactory $eavSetupFactory,
	\Magento\Eav\Model\Config $eavConfig)
	{
		$this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
		
	}
	
	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
              if (version_compare($context->getVersion(), '1.0.2', '<')) {
			
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
			$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, "companyname");
			$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, "vatnumber");
			$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, "kvknumber");
			
			$eavSetup->addAttribute(
				\Magento\Customer\Model\Customer::ENTITY,
				'companyname',
				[
					'group'        => 'General',
					'backend'      => '',
					'type'         => 'varchar',
					'label'        => 'Companyname',                   
					'class'        => '',
					'input'        => 'text',
					'global'       => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
					'required'     => false,
					'default'      => '',
					'visible'      => true,
					'user_defined' => false,
					'position'     => 999,
					'system'       => 0,
										
				]
			)->addAttribute(
				\Magento\Customer\Model\Customer::ENTITY,
				'vatnumber',
				[
					'group'        => 'General',
					'backend'      => '',
					'type'         => 'varchar',
					'label'        => 'VAT number',                   
					'class'        => '',
					'input'        => 'text',
					'global'       => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
					'required'     => false,
					'default'      => '',
					'visible'      => true,
					'user_defined' => false,
					'position'     => 999,
					'system'       => 0,
										
				]
			)->addAttribute(
				\Magento\Customer\Model\Customer::ENTITY,
				'kvknumber',
				[
					'group'        => 'General',
					'backend'      => '',
					'type'         => 'varchar',
					'label'        => 'KVK number',                   
					'class'        => '',
					'input'        => 'text',
					'global'       => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
					'required'     => false,
					'default'      => '',
					'visible'      => true,
					'user_defined' => false,
					'position'     => 999,
					'system'       => 0,
										
				]
			);	
			
			$used_in_forms=array();

			$used_in_forms[]="adminhtml_customer";
			$used_in_forms[]="checkout_register";
			$used_in_forms[]="customer_account_create";
			$used_in_forms[]="customer_account_edit";

			$attributeCompanyname = $this->eavConfig->getAttribute("customer", "companyname");
			$attributeCompanyname->setData("used_in_forms", $used_in_forms);
			$attributeCompanyname->save();


			$attributeVatnumber = $this->eavConfig->getAttribute("customer", "vatnumber");
			$attributeVatnumber->setData("used_in_forms", $used_in_forms);
			$attributeVatnumber->save();

			$attributeKvknumber = $this->eavConfig->getAttribute("customer", "kvknumber");
			$attributeKvknumber->setData("used_in_forms", $used_in_forms);
			$attributeKvknumber->save();

		}

	}
}
