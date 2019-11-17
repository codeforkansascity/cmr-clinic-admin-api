// Used by app/Lib/Uploader.php -- https://github.com/charliekassel/vuejs-uploader
//
import FileUpload from './FileUpload'
export default class ImageUpload extends FileUpload {
  constructor (file) {
    super(file)
    this.image = null
  }
}
