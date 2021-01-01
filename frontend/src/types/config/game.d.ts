export interface IappGameConfig {
  [key: string]:
    | string
    | string[]
    | number
    | object
    | IPreloadCallBack
    | ICreatedCallBack
  type: number
  width: number
  height: number
  physics: {
    default: string
    arcade: {
      gravity: { y: number }
    }
  }
  scene: {
    preload: IPreloadCallBack
    create: ICreatedCallBack
  }
}

export type IPreloadCallBack = () => void
export type ICreatedCallBack = (data: object) => void

export interface IGamePhysicSetting {
  [key: string]: string | number | object
  default: string
  arcade: {
    gravity: { y: number }
  }
}
