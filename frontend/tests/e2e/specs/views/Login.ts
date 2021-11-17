// https://docs.cypress.io/api/introduction/api.html
// import { cypress } from 'cypress/types'
/* eslint-disable @typescript-eslint/no-var-requires */

import { IAppConfig } from '@/types/config/data'
const config: IAppConfig = require('@/config/data')
import {
  testLoginData,
  testAdminData,
  testAuthenticatedData
} from '../../localData'

const targetPage = '/login'

describe('Login Page Test', () => {
  it('Visits Login Form.', () => {
    // 通信レスポンスのレスポンス設定
    cy.server()
      .route('POST', config.authEndpoint.AUTH_LOGIN, testAuthenticatedData)
      .as('load')

    cy.server()
      .route('POST', config.authEndpoint.AUTH_SELF, testAdminData)
      .as('self')

    cy.visit(targetPage)

    cy.contains('div', 'Login Form')
    cy.get('.p-button-raised').should('be.disabled')

    cy.get('#email')
      .type(testLoginData.email)
      .should('have.value', testLoginData.email)

    cy.get('#password')
      .type(testLoginData.password)
      .should('have.value', testLoginData.password)

    // login action
    cy.get('.p-button-raised').click('center')

    // 管理画面へのリダイレクトチェック
    cy.contains('h1', '管理サービス')
  })
})
