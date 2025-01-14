import { LitElement, html} from "lit";
import axios from "axios";
import "./commentText.js";

export class Commentaire extends LitElement {
  constructor() {
    super();
    this.commentlist = [];
  }

  static properties = {
      commentlist: {type:Object},
      id:{type:Number}
  };



  render() {
    return html`
        <slot name="comment">

          
        </slot>
        ${
            
            this.commentlist.map(
                (post) =>
                    html`<comment-text .content=${post}>`
            )
        }
        <h2>Commentaire</h2>
        <p>Vous pouvez laisser un commentaire</p>
        <form @submit=${this.commentPost} class="">
          <div class="form-group">
              <label for="commentaire">Commentaire</label>
              <textarea required class="form-control" id="commentaire" name="commentaire" rows="3" ></textarea>
          </div>
          <button type="submit"  class="btn btn-primary">Envoyer</button>
        </form>
    `;
  }
  commentPost(event){
    event.preventDefault();
    let value = this.comment.value;
    let submit = this.submit;
    if(value !== '') {
      this.commentlist = [...this.commentlist,
        {value}];
      this.comment.value = '';
        submit.disabled = true;

        axios.post(APIURI+'comment', {
          patate: value,
          id:this.id,
        }, {
            headers: {
                'Content-Type': 'application/json',
            }
            }).then(function(response){



            }).catch(function(error){
            console.log(error);
            }
        );
        axios.get(APIURI+'comment/'+this.id).then(function(response){
            this.commentlist = [...this.commentlist,
                response.comments.map(
                    (comment) => this.commentLis.exists()

                )];
        }.bind(this)).catch(function(error){
                console.log(error);
            }
        );
      setTimeout(function(){
        submit.disabled = false;
      }, 2000);
    }
  }

  get comment() {
    return this.renderRoot?.querySelector("#commentaire") ?? null;
  }

  get submit() {
    return this.renderRoot?.querySelector("button[type='submit']") ?? null;
  }
}

customElements.define('comment-element', Commentaire);

