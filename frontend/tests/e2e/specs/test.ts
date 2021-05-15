// https://docs.cypress.io/api/introduction/api.html
// import { cypress } from 'cypress/types'

describe('Root Page Test', () => {
  it('Visits the app root url with no authData.', () => {
    cy.visit('/')

    // redirect login form
    cy.contains('div', 'Login Form')
    cy.get('button').should('be.disabled')

    cy.get('#email').should('have.value', '')

    cy.get('#password').should('have.value', '')
  })
})
