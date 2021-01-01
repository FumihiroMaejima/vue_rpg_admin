import {
  IPreloadCallBack,
  ICreatedCallBack /* IappGameConfig */
} from '@/types'
export const preloadCallBack: IPreloadCallBack = () => {
  console.log('preload')
}

export const createCallBack: ICreatedCallBack = (data: object) => {
  console.log(JSON.stringify(data, null, 2))
}

export const appGameConfig = {
  type: 0, // set Phaser.AUTO.
  width: 400,
  height: 300,
  physics: {
    default: 'arcade',
    arcade: {
      gravity: { y: 200 }
    }
  },
  scene: {
    preload: preloadCallBack,
    create: createCallBack
  }
}
