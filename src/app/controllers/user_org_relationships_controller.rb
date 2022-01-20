class UserOrgRelationshipsController < ApplicationController
  before_action :org_admin_signed_in?

  def create
    organization = current_org_admin.organization.find(params[:org_name])
    user = User.find(params[:user_name])
    if user.join(organization)
      render status: 201, json: {
        "result": true,
        "status": 201,
        "message": "Created",
        "data": {
          "user_name": user.name.to_s,
          "org_name": organization.name.to_s,
          "created_at": organization.created_at.to_s
        }
      }
    else
      render status: 400, json: {
        "result": false,
        "status": 400,
        "message": "Bad Request"
      }
    end
  end

  def destroy
    organization = current_org_admin.organization.find(params[:org_name])
    user = User.find(params[:user_name])
    if user.withdraw(organization)
      render status: 204, json:{
        "result": true,
        "status": 204,
        "message": "No Content"
      }
    else
      render status: 400, json:{
        "result": false,
        "status": 400,
        "message": "Bad Request",
      }
    end
  end
end
