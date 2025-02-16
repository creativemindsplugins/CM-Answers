<div class="cm-wizard-step step-0">
    <h1>Welcome to the CM Answers Setup Wizard</h1>
    <p>Thank you for installing the CM Answers plugin!</p>
    <p>This plugin enhances your website by enabling a dynamic Q&A platform where users can ask questions, provide<br/>
        answers, and engage in discussions, fostering a community-driven environment.</p>
    <img class="img" src="<?php echo CMA_SetupWizard::$wizard_url . 'assets/img/wizard_logo.png';?>">
    <p>To help you get started, we’ve prepared a quick setup wizard to guide you through these steps:</p>
    <ul>
        <li>• Configuring essential settings</li>
        <li>• Customizing the appearance of the Q&A section</li>
        <li>• Setting up moderation options</li>
    </ul>
    <button class="next-step" data-step="0">Start</button>
    <p><a href="<?php echo admin_url( 'admin.php?page='. CMA_SetupWizard::$setting_page_slug ); ?>" >Skip the setup wizard</a></p>
</div>
<?php echo CMA_SetupWizard::renderSteps(); ?>