// pluginsディレクトリ内のexport宣言
export * from '@/types/plugins/game'

// 1. 拡張した型を定義する前に必ず 'vue' をインポートする
import Vue from 'vue'
import { IAppConfig } from '@/types/config'

// 2. 拡張したい型が含まれるファイルを指定
// Vue のコンストラクタの型は types/vue.d.ts に入っている
declare module 'vue/types/vue' {
  // 3. 拡張した Vue を定義
  interface Vue {
    $AppConfig: IAppConfig
  }
}
