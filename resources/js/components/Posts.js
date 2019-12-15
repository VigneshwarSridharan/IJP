import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import http from 'axios';

console.log(url())

const Posts = () => {
    let defaultState = {
        path: "http://localhost:8000/posts",
        data: [],
        first_page_url: "http://localhost:8000/posts?page=1",
        next_page_url: "http://localhost:8000/posts?page=2",
        prev_page_url: null,
        last_page_url: "http://localhost:8000/posts?page=2",
        current_page: 1,
        last_page: 2,
        from: 1,
        to: 2,
        per_page: 2,
        total: 4
    }
    let [state, setState] = useState(defaultState);
    let {data} = state;
    useEffect(() => {
        // http.post('/posts').then(res => res.data).then(res => {
        http.post('/posts').then(res => res.data).then(({status,response}) => {
            if (status == 'success') {
                setState(response);
            }
        })
    }, []);

    
    return (
        <>
            {data.map((post, inx) => {
                return (
                    <div className="card mb-3 post-item pointer" data-toggle="modal" data-target="#post-{{$key}}" key={inx}>
                        <div className="card-body d-flex">
                            <div className="site-badge blue mb-3">Issue #{ post.id + 1}</div>
                            <div className="featured-image" style={{backgroundImage:`url(${storage(post.image)}`}}></div>
                            <div className="content">
                                <h4 className="title">{post.title}</h4>
                                <p className="excerpt">{post.excerpt}</p>
                                <div className="d-flex justify-content-between align-items-center">
                                    <ul className="post-info">
                                        <li><i className="fas fa-thumbs-up"></i> 45</li>
                                        <li><i className="fas fa-comment"></i> 32</li>
                                    </ul>
                                    <div className="d-flex align-items-center">
                                        <div className="avatar" style={{backgroundImage:`url(${storage(post.avatar)})`}} ></div>
                                        <div>{post.name}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )
            })}
            <div className="d-flex justify-content-between">
                <div className="btn btn-primary">Prev</div>
                <div className="btn btn-primary">Next</div>
            </div>
        </>
    )
}

export default Posts;

if (document.getElementById('posts')) {
    ReactDOM.render(<Posts />, document.getElementById('posts'))
}