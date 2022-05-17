import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { map, Observable } from 'rxjs';
import { Article } from '../models/Article';

@Injectable({
  providedIn: 'root',
})
export class CrudService {
  // base api url
  public url = environment.web_api_url_base;

  constructor(private http: HttpClient) {}

  // Get all articles
  getArticles(): Observable<Article[]> {
    return this.http
      .get<Article[]>(`${this.url}/read.php`)
      .pipe(map((data) => data));
  }

  // Set an article
  createArticle(article: Article): Observable<Article> {
    return this.http
      .post<Article>(`${this.url}/create.php`, article)
      .pipe(map((data) => data));
  }

  // Update an article
  updateArticle(article: Article) {
    return this.http
      .put<Article>(`${this.url}/update.php`, article)
      .pipe(map((data) => data));
  }

  // Delete an article
  deleteArticle(id: number) {
    return this.http
      .delete<Article>(`${this.url}/delete.php?id=${id}`)
      .pipe((data) => data);
  }

  // Get single article
  getArticle(id: number): Observable<Article> {
    return this.http.get<Article>(this.url + 'view_one.php?id=' + id).pipe(
      map((response) => response )
    );
  }
}
