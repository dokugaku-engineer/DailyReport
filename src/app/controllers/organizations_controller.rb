class OrganizationsController < ApplicationController
  before_action :org_admin_signed_in?
  before_action :correct_org_admin, only: %i[update destroy]
  
  def create
    organization = current_org_admin.organizations.build(organization_params)
    if organization.save
      render status: 201, json: {
        "result": true,
        "status": 201,
        "message": "Created",
        "data": {
          "name": organization.name.to_s,
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

  def update
    if @organization.update(organization_params)
      render status: 200, json: {
        "result": true,
        "status": 200,
        "message": "Success",
        "data": {
          "name": organization.name.to_s,
          "created_at": organization.created_at.to_s
        }
      }
    else
      render status: 400, json:{
        "result": false,
        "status": 400,
        "message": "Bad Request",
      }
    end
  end

  def destroy
    if @organization.destroy
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

  private

  def organization_params
    params.require(:organization).permit(:name)
  end

  def correct_org_admin
    @organization = current_org_admin.organizations.find_by(id: params[:id])
    return if @organization
    
    render status: 400, json: {
      "result": false,
      "status": 400,
      "message": "Bad Request"
    }
  end
end
