/* eslint-disable @typescript-eslint/no-var-requires */
/* eslint-disable @typescript-eslint/camelcase */

import { IAppConfig } from '@/types/config/data'
const config: IAppConfig = require('@/config/data')

export const testLoginData = {
  email: 'test name',
  password: 'test name'
}

export const testAdminData = {
  name: 'test name',
  id: 1,
  authority: ['master']
}

export const testAuthenticatedData = {
  access_token: 'testToken',
  token_type: 'bearer',
  expires_in: 3600,
  user: testAdminData
}
