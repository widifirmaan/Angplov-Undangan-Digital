!(function (s, l) {
    window.wdp = window.wdp || {};
    var d = { Views: {}, Models: {}, Collections: {}, Behaviors: {}, Layout: null, Manager: null };
    (d.Models.Template = Backbone.Model.extend({ defaults: { template_id: 0, type: "", subtype: "", title: "", thumbnail: "", tags: [], url: "" } })),
        (d.Collections.Template = Backbone.Collection.extend({ model: d.Models.Template })),
        (d.Behaviors.InsertTemplate = Marionette.Behavior.extend({
            ui: { insertButton: ".weddingpressElementorLibrary-insert-button" },
            events: { "click @ui.insertButton": "onInsertButtonClick" },
            onInsertButtonClick: function () {
                wdp.library.printNewTemplate({ model: this.view.model });
            },
        })),
        (d.Views.EmptyTemplateCollection = Marionette.ItemView.extend({
            id: "elementor-template-library-templates-empty",
            template: "#tmpl-weddingpressElementorLibrary-empty",
            ui: { title: ".elementor-template-library-blank-title", message: ".elementor-template-library-blank-message" },
            modesStrings: {
                empty: { title: weddingpressElementorLocal.noTemplateFoundTitle, message: weddingpressElementorLocal.noTemplateFoundMessage },
                noResults: { title: weddingpressElementorLocal.noTemplateResultTitle, message: weddingpressElementorLocal.noTemplateResultMessage },
            },
            getCurrentMode: function () {
                return wdp.library.getTag("text") ? "noResults" : "empty";
            },
            onRender: function () {
                var e = this.modesStrings[this.getCurrentMode()];
                this.ui.title.html(e.title), this.ui.message.html(e.message);
            },
        })),
        (d.Views.Loading = Marionette.ItemView.extend({ template: "#tmpl-weddingpressElementorLibrary-loading", id: "weddingpressElementorLibrary-loading" })),
        (d.Views.Logo = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-logo",
            className: "weddingpressElementorLibrary-logo",
            templateHelpers: function () {
                return { title: this.getOption("title") };
            },
        })),
        (d.Views.BackButton = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-header-back",
            id: "elementor-template-library-header-preview-back",
            className: "weddingpressElementorLibrary-header-back",
            events: function () {
                return { click: "onClick" };
            },
            onClick: function () {
                wdp.library.showBlocksView();
            },
        })),
        (d.Views.Menu = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-header-menu",
            id: "elementor-template-library-header-menu",
            className: "weddingpressElementorLibrary-header-menu",
            templateHelpers: function () {
                return wdp.library.getTabs();
            },
        })),
        (d.Views.Actions = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-header-actions",
            id: "elementor-template-library-header-actions",
            ui: { sync: "#weddingpressElementorLibrary-header-sync i" },
            events: { "click @ui.sync": "onSyncClick" },
            onSyncClick: function () {
                var e = this;
                e.ui.sync.addClass("eicon-animation-spin"),
                    wdp.library.requestLibraryData({
                        onUpdate: function () {
                            e.ui.sync.removeClass("eicon-animation-spin"), wdp.library.changeView();
                        },
                        forceUpdate: !0,
                        forceSync: !0,
                    });
            },
        })),
        (d.Views.InsertWrapper = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-header-insert",
            id: "elementor-template-library-header-preview",
            behaviors: { printNewTemplate: { behaviorClass: d.Behaviors.InsertTemplate } },
        })),
        (d.Views.Preview = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-preview",
            className: "weddingpressElementorLibrary-preview",
            ui: function () {
                return { iframe: "> iframe" };
            },
            onRender: function () {
                this.ui.iframe.attr("src", this.getOption("url")).hide();
                var e = this,
                    t = new d.Views.Loading().render();
                this.$el.append(t.el),
                    this.ui.iframe.on("load", function () {
                        e.$el.find("#weddingpressElementorLibrary-loading").remove(), e.ui.iframe.show();
                    });
            },
        })),
        (d.Views.TemplateCollection = Marionette.CompositeView.extend({
            template: "#tmpl-weddingpressElementorLibrary-templates",
            id: "weddingpressElementorLibrary-templates",
            childViewContainer: "#weddingpressElementorLibrary-list",
            emptyView: function () {
                return new d.Views.EmptyTemplateCollection();
            },
            ui: { templatesWindow: ".weddingpressElementorLibrary-window", textFilter: "#weddingpressElementorLibrary-search", tagsFilter: "#weddingpressElementorLibrary-filter-tags", filterBar: "#weddingpressElementorLibrary-toolbar-filter" },
            events: { "input @ui.textFilter": "onTextFilterInput", "click @ui.tagsFilter li": "onTagsClick" },
            getChildView: function (e) {
                return d.Views.Template;
            },
            initialize: function () {
                this.listenTo(wdp.library.channels.templates, "filter:change", this._renderChildren);
            },
            filter: function (i) {
                var e = wdp.library.getTagTerms(),
                    r = !0;
                return (
                    _.each(e, function (e, t) {
                        var o = wdp.library.getTag(t);
                        if (o && e.callback) {
                            var n = e.callback.call(i, o);
                            return n || (r = !1), n;
                        }
                    }),
                    r
                );
            },
            setMasonrySkin: function () {
                var e = new elementorModules.utils.Masonry({ container: this.$childViewContainer, items: this.$childViewContainer.children() });
                this.$childViewContainer.imagesLoaded(e.run.bind(e));
            },
            onRenderCollection: function () {
                this.setMasonrySkin(), this.updatePerfectScrollbar();
            },
            onTextFilterInput: function () {
                var e = this;
                _.defer(function () {
                    wdp.library.setTag("text", e.ui.textFilter.val());
                });
            },
            onTagsClick: function (e) {
                var t = s(e.currentTarget),
                    o = t.data("tag");
                wdp.library.setTag("tags", o), t.addClass("active").siblings().removeClass("active");
            },
            updatePerfectScrollbar: function () {
                this.perfectScrollbar || (this.perfectScrollbar = new PerfectScrollbar(this.ui.templatesWindow[0], { suppressScrollX: !0 })), (this.perfectScrollbar.isRtl = !1), this.perfectScrollbar.update();
            },
            onRender: function () {
                this.updatePerfectScrollbar();
            },
        })),
        (d.Views.Template = Marionette.ItemView.extend({
            template: "#tmpl-weddingpressElementorLibrary-template",
            className: "weddingpressElementorLibrary-template",
            ui: { previewButton: ".weddingpressElementorLibrary-preview-button, .weddingpressElementorLibrary-template-preview" },
            events: { "click @ui.previewButton": "onPreviewButtonClick" },
            behaviors: { printNewTemplate: { behaviorClass: d.Behaviors.InsertTemplate } },
            onPreviewButtonClick: function () {
                wdp.library.showPreviewView(this.model);
            },
        })),
        (d.Modal = elementorModules.common.views.modal.Layout.extend({
            getModalOptions: function () {
                return { id: "weddingpressElementorLibrary-modal", hide: { onOutsideClick: !1, onEscKeyPress: !0, onBackgroundClick: !1 } };
            },
            printTemplateButton: function (e) {
                var t = 1 == e.isPro && 0 == weddingpressElementorLocal.proBooster ? "get-pro-button" : "insert-button";
                return (viewId = "#tmpl-weddingpressElementorLibrary-" + t), (template = Marionette.TemplateCache.get(viewId)), Marionette.Renderer.render(template);
            },
            showLogo: function (e) {
                this.getHeaderView().logoArea.show(new d.Views.Logo(e));
            },
            showDefaultHeader: function () {
                this.showLogo({ title: "WEDDINGPRESS LIBRARY" });
                var e = this.getHeaderView();
                e.tools.show(new d.Views.Actions()), e.menuArea.reset();
            },
            showPreviewView: function (e) {
                var t = this.getHeaderView();
                t.logoArea.show(new d.Views.BackButton()), t.tools.show(new d.Views.InsertWrapper({ model: e })), this.modalContent.show(new d.Views.Preview({ url: e.get("url") }));
            },
            showBlocksView: function (e) {
                this.modalContent.show(new d.Views.TemplateCollection({ collection: e }));
            },
        })),
        (d.Manager = function () {
            (ELEMENTOR_DG_SECTION = ".elementor-add-new-section .elementor-add-section-drag-title"),
                ($weddingpressLibraryButton =
                    '<div class="elementor-add-section-area-button elementor-add-weddingpress-button" title="Add Weddingpress Template" style="margin-left: 5px; vertical-align: bottom;"><img src="' +
                    weddingpressElementorLocal.ASSETS_URL +
                    'admin/assets/img/wdp-icon.png"; width: 30px; height: 30px;"/></div>');
            var e,
                o,
                n,
                t,
                i = this;
            function r() {
                var e = window.elementor.sections,
                    t = s(this).closest(".elementor-top-section"),
                    o = t.data("model-cid");
                e.currentView.collection.length &&
                    _.each(e.currentView.collection.models, function (e, t) {
                        o === e.cid && (i.atIndex = t);
                    }),
                    t.prev(".elementor-add-section").find(ELEMENTOR_DG_SECTION).before($weddingpressLibraryButton);
            }
            function a() {
                var o = window.elementor.$previewContents,
                    n = setInterval(function () {
                        var e, t;
                        (t = (e = o).find(ELEMENTOR_DG_SECTION)).length && t.before($weddingpressLibraryButton),
                            e.on("click.onAddElement", ".elementor-editor-section-settings .elementor-editor-element-add", r),
                            s(".weddingpressElementorLibrary-preview").css("width", "100%"),
                            0 < o.find(".elementor-add-new-section").length && clearInterval(n);
                    }, 100);
                o.on("click.onAddTemplateButton", ".elementor-add-weddingpress-button", i.showModal.bind(i));
            }
            (this.atIndex = -1),
                (this.channels = { tabs: Backbone.Radio.channel("tabs"), templates: Backbone.Radio.channel("templates") }),
                (this.changeView = function () {
                    i.setTag("tags", "", !0), i.setTag("text", "", !0), i.getModal().showBlocksView(n);
                }),
                (this.setTag = function (e, t, o) {
                    i.channels.templates.reply("filter:" + e, t), o || i.channels.templates.trigger("filter:change");
                }),
                (this.getTag = function (e) {
                    return i.channels.templates.request("filter:" + e);
                }),
                (this.getTagTerms = function () {
                    return {
                        tags: {
                            callback: function (t) {
                                return _.any(this.get("tags"), function (e) {
                                    return 0 <= e.indexOf(t);
                                });
                            },
                        },
                        text: {
                            callback: function (t) {
                                return (
                                    (t = t.toLowerCase()),
                                    0 <= this.get("title").toLowerCase().indexOf(t) ||
                                        _.any(this.get("tags"), function (e) {
                                            return 0 <= e.indexOf(t);
                                        })
                                );
                            },
                        },
                    };
                }),
                (this.showModal = function () {
                    i.getModal().showModal(), i.showBlocksView();
                }),
                (this.closeModal = function () {
                    this.getModal().hideModal();
                }),
                (this.getModal = function () {
                    return (e = e || new d.Modal());
                }),
                (this.run = function () {
                    l.on("preview:loaded", a);
                }),
                (this.getTabs = function () {
                    return { tabs: { blocks: { title: "Blocks", active: !0 } } };
                }),
                (this.getTags = function () {
                    return o;
                }),
                (this.showBlocksView = function () {
                    i.getModal().showDefaultHeader(),
                        i.setTag("tags", "", !0),
                        i.setTag("text", "", !0),
                        i.loadTemplates(function () {
                            i.getModal().showBlocksView(n);
                        });
                }),
                (this.showPreviewView = function (e) {
                    i.getModal().showPreviewView(e);
                }),
                (this.loadTemplates = function (e) {
                    i.requestLibraryData({
                        onBeforeUpdate: i.getModal().showLoadingView.bind(i.getModal()),
                        onUpdate: function () {
                            i.getModal().hideLoadingView(), e && e();
                        },
                    });
                }),
                (this.requestLibraryData = function (t) {
                    var e;
                    !n || t.forceUpdate
                        ? (t.onBeforeUpdate && t.onBeforeUpdate(),
                          (e = {
                              data: {},
                              success: function (e) {
                                  (n = new d.Collections.Template(e.templates)), e.tags && (o = e.tags), t.onUpdate && t.onUpdate();
                              },
                          }),
                          t.forceSync && (e.data.sync = !0),
                          elementorCommon.ajax.addRequest("get_weddingpress_library_data", e))
                        : t.onUpdate && t.onUpdate();
                }),
                (this.getAjaxTemplateData = function (e, t) {
                    var o = { unique_id: e, data: { edit_mode: !0, display: !0, template_id: e } };
                    t && jQuery.extend(!0, o, t), elementorCommon.ajax.addRequest("get_weddingpress_single_template_data", o);
                }),
                (this.printNewTemplate = function (e) {
                    var o = e.model,
                        n = this;
                    n.getModal().showLoadingView(),
                        n.getAjaxTemplateData(o.get("template_id"), {
                            success: function (e) {
                                n.getModal().hideLoadingView(), n.getModal().hideModal();
                                var t = {};
                                -1 !== n.atIndex && (t.at = n.atIndex), $e.run("document/elements/import", { model: o, data: e, options: t }), (n.atIndex = -1);
                            },
                            error: function (e) {
                                n.showErrorDialog(e);
                            },
                            complete: function (e) {
                                n.getModal().hideLoadingView();
                            },
                        });
                }),
                (this.showErrorDialog = function (e) {
                    i.getErrorDialog().setMessage("The following error(s) occurred while processing the request").show();
                }),
                (this.getErrorDialog = function () {
                    return (t = t || elementorCommon.dialogsManager.createWidget("alert", { id: "elementor-template-library-error-dialog", headerMessage: "An error occurred" }));
                });
        }),
        (window.wdp.library = new d.Manager()),
        window.wdp.library.run();
})(jQuery, window.elementor);
