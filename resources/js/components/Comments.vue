<template>
    <div>
        <h2>What is Lorem Ipsum?</h2>
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>

        <hr />

        <h2>Comments</h2>
        <button class="btn btn-danger" @click="addComments()">Add Comments</button>
        <hr />

        <div class="card mb-1" v-for="levelOneComment in comments" :key="levelOneComment.id">
	    <div class="card-body">
	        <div class="row">
        	    <div class="col-md-2">
        	        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
        	        <p class="text-secondary text-center">{{ levelOneComment.created_at | formatDate }}</p>
        	    </div>
        	    <div class="col-md-10">
        	        <p>
        	            <a class="float-left" href="#"><strong>User Name</strong></a>
        	        </p>
        	        <div class="clearfix"></div>
        	        <p>{{ levelOneComment.comment }}</p>
        	        <p>
                        <button class="float-right btn btn-outline-primary ml-2" @click="replyCommentFun(levelOneComment.id)">Reply</button>
        	        </p>
        	    </div>
	        </div>
                <div v-if="levelOneComment.children_comments.length > 0">
                    <div class="card card-inner mb-1" v-for="levelTwoComment in levelOneComment.children_comments" :key="levelTwoComment.id">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                                    <p class="text-secondary text-center">{{ levelTwoComment.created_at | formatDate }}</p>
                                </div>
                                <div class="col-md-10">
                                    <p><a href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>User Name</strong></a></p>
                                    <p>{{ levelTwoComment.comment }}</p>
                                    <p>
                                        <button class="float-right btn btn-outline-primary ml-2" @click="replyCommentFun(levelTwoComment.id)">Reply</button>
                                </p>
                                </div>
                            </div>

                            <div v-if="levelTwoComment.comments.length > 0">
                                <div class="card card-inner mb-1" v-for="levelThirdComment in levelTwoComment.comments" :key="levelThirdComment.id">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                                                <p class="text-secondary text-center">{{ levelThirdComment.created_at | formatDate }}</p>
                                            </div>
                                            <div class="col-md-10">
                                                <p><a href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>User Name</strong></a></p>
                                                <p>{{ levelThirdComment.comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
	                </div>
                </div>
	    </div>
	</div>

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showModal = false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" id="comment" name="comment" v-model="comment" required placeholder="type comment here..."></textarea>
                            <div class="alert alert-danger mt-1" role="alert" v-if="commentErrormessage">
                                {{commentErrormessage}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="postComment()">Submit</button>
                            <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </transition>
        </div>

        <div v-if="showReplyModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reply Comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click="showReplyModal = false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" id="replyComment" name="replyComment" v-model="replyComment" required placeholder="type comment here..."></textarea>
                            <input type="hidden" v-model="parent_comment_id" />
                            <div class="alert alert-danger mt-1" role="alert" v-if="replyCommentErrormessage">
                                {{ replyCommentErrormessage }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="postReplyComment()">Submit</button>
                            <button type="button" class="btn btn-secondary" @click="showReplyModal = false">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                comments: [],
                showModal: false,
                comment: '',
                commentErrormessage: '',
                showReplyModal: false,
                replyComment: '',
                parent_comment_id: 0,
                replyCommentErrormessage: '',
            }
        },
        created() {
            this.getComments();
        },
        methods: {
            getComments() {
                this.axios
                    .get('/getComments')
                    .then(response => {
                        this.comments = response.data;
                    });
            },
            addComments() {
                this.showModal = true;
            },
            postComment() {
                let comment = this.comment;
                axios.post('/storeComment', {comment}).then(response => {
                    this.comment = '';
                    this.commentErrormessage = '';
                    this.getComments();
                    this.showModal = false;
                }).catch(error=> {
                    console.log('error', error)
                    let errors = error.response.data.errors;
                    let errormessage = [];

                    Object.keys(errors).forEach(function(key) {
                        errormessage.push(errors[key]);
                    });

                    this.commentErrormessage = errormessage.join('</br>');
                });
            },
            replyCommentFun(parent_comment_id) {
                this.showReplyModal = true;
                this.parent_comment_id = parent_comment_id;
            },
            postReplyComment() {
                let comment = this.replyComment;
                let comment_id = this.parent_comment_id;
                axios.post('/storeReplyComment', {comment, comment_id}).then(response => {
                    this.replyComment = '';
                    this.replyCommentErrormessage = '';
                    this.getComments();
                    this.showReplyModal = false;
                }).catch(error=> {
                    console.log('error', error)
                    let errors = error.response.data.errors;
                    let errormessage = [];

                    Object.keys(errors).forEach(function(key) {
                        errormessage.push(errors[key]);
                    });

                    this.replyCommentErrormessage = errormessage.join('</br>');
                });
            },
        }
    }
</script>