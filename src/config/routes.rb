Rails.application.routes.draw do
  mount_devise_token_auth_for "User", at: "users"

  mount_devise_token_auth_for 'OrgAdmin', at: 'org_admins'
  as :org_admin do
    # Define routes for OrgAdmin within this block.
  end

  post "/slack_posts", to: "slack_posts#create"

  post "/organizations", to: "organizations#create"
  patch "/organizations", to: "organizations#update"
  delete "/organizations", to: "organizations#destroy"
end
