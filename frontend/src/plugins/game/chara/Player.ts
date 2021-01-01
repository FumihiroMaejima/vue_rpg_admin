/* eslint-disable @typescript-eslint/no-var-requires */
// import { IPlayer } from '@/types'

export default class Player {
  private hp: number
  private power: number
  private deffence: number
  private speed: number

  /**
   * initialize player parameter.
   * @param {} none
   * @return {void}
   */
  constructor() {
    this.hp = 100
    this.power = 100
    this.deffence = 100
    this.speed = 100
  }

  /**
   * methods
   * @param {}
   * @return {void}
   */
  public initializePlayerParam(): number {
    return Math.random() + 1
  }

  /**
   * methods
   * @param {}
   * @return {void}
   */
  // public functionName() {}
}
