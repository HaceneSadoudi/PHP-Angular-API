import { Component, OnInit } from '@angular/core';
import { Article } from '../../models/Article';
import { CrudService } from '../../services/crud.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.sass']
})
export class DashboardComponent implements OnInit {
  articles:  Article[] = [];
  selectedArticle:  Article  = { id :  null as any , title: null as any, description:  null as any, published: null as any};


  constructor(private crudService: CrudService) { }

  ngOnInit(): void {
    this.crudService.getArticles().subscribe((articles: Article[]) => {
      this.articles = articles;
    })
  }

  createOrUpdateArticle(form: any){
    if(form.value.title.trim() == null || form.value.description.trim() == null) return;
    if(form.value.title.trim() == "" || form.value.description.trim() == "") return;
    form.value.published = form.value.published == 1 ? 1 : 0;
    if(this.selectedArticle && this.selectedArticle.id){
      form.value.id = this.selectedArticle.id;
      this.crudService.updateArticle(form.value).subscribe((article: Article)=>{
        console.log("Article updated" , article);
      });
    }else{
      this.crudService.createArticle(form.value).subscribe((article: Article)=>{
        console.log("Article created, ", article);
      });
    }
    window.location.reload();
  }


  selectArticle(article: Article){
    this.selectedArticle = article;
  }

  deleteArticle(id: number){
    const that = this;
    Swal.fire({
      title: 'Êtes-vous sûr de vouloir supprimer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Oui, je veux supprimer'
    }).then((result: any) => {
      if (result.isConfirmed) {
        that.crudService.deleteArticle(id).subscribe((article: Article)=>{
          console.log("Article deleted, ", article);
        });
        Swal.fire(
          'Supprimer!',
          'L\'article a été supprimé',
          'success'
        ).then(() => {
          window.location.reload(); 
        })
      }
    });
  }


}
