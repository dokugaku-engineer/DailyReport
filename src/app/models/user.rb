class User < ApplicationRecord
  has_many :slack_posts, dependent: :destroy

  has_many :user_org_relationships
  has_many :organizations, through: :user_org_relationships

  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable, :trackable and :omniauthable
  devise :database_authenticatable, :registerable,
         :recoverable, :rememberable, :validatable
  include DeviseTokenAuth::Concerns::User

  def join(organization)
    self.user_organization_relationships.find_or_create_by(organization_id: organization.id)
  end

  def withdraw(organization)
    self.user_organization_relationships.find_or_create_by(organization_id: organization.id)
  end
end
