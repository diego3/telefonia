
Feature('Firstest');

Scenario('Test that the home page is up', (I) => {
    I.amOnPage("/");
    I.see("Agenda Telefônica");
});
